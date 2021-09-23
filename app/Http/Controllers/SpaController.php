<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\ShippingBar;
use App\Models\ShippingBarClick;
use App\Models\ShippingBarCustomCode;
use App\Models\UserImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Laravel\Vapor\Contracts\SignedStorageUrlController as SignedStorageUrlControllerContract;

class SpaController extends Controller implements SignedStorageUrlControllerContract
{
    public function fsbs()
    {
        $user = Auth::user();
        $fsbs = ShippingBar::where('user_id', $user->id)->get(); // 所有bar
        foreach ($fsbs as $fsb) {
            // 颜色转换
            if (!$fsb->bg_image) {
                $fsb->bg_color = $this->hex2rgba($fsb->bg_color, $fsb->bg_opacity / 100);
            }
            $fsb->page_targets = json_decode($fsb->page_targets);
        }
        return $fsbs;
    }

    public function fsb($id)
    {
        $bar = ShippingBar::find($id);
        if ($bar && $bar->start_at) {
            $bar['date_range'] = [
                strlen($bar->start_at) == 13 ? $bar->start_at : $bar->start_at * 1000,
                strlen($bar->end_at) == 13 ? $bar->end_at : $bar->end_at * 1000,
            ];
        }
        $bar->page_targets = json_decode($bar->page_targets);
        $bar->geo_targets = json_decode($bar->geo_targets);

        return $bar;
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $plan = $user->plan;

        $validated = $request->validate([
            'name' => 'required|min:1',
            'shipping_goal' => 'required|numeric',
            'shipping_goal_currency' => 'required',
            'link' => 'required_if:add_link,true',
            'expires_days' => 'required_if:add_close_btn,true',
        ]);
        $data = $request->all();
        $data['user_id'] = $user->id;
        $data['active'] = $request->active;
        $data['add_link'] = $request->add_link;
        $data['add_close_btn'] = $request->add_close_btn;
        $data['currency_conversion'] = $request->currency_conversion;
        $data['shipping_goal_currency_symbol'] = $user->money_format_symbol;
        $data['text_color'] = $request->text_color ? $request->text_color : '#FFFFFF';
        $data['bg_color'] = $request->bg_color ? $request->bg_color : '#000000';
        $data['bg_opacity'] = $request->bg_opacity ? $request->bg_opacity : 100;
        $data['shipping_goal_text_color'] = $request->shipping_goal_text_color ? $request->shipping_goal_text_color : '#ffff00';
        $data['close_btn_color'] = $request->close_btn_color ? $request->close_btn_color : '#ffff00';
        $data['page_targets'] = $request->page_targets;
        $start_at = $request->date_range ? $request->date_range[0] : null;
        $end_at = $request->date_range ? $request->date_range[1] : null;
        $data['start_at'] = $start_at;
        $data['end_at'] = $end_at;
        unset($data['date_range']);

        $data['created_by'] = ShippingBar::CREATED_BY_USER;

        return ShippingBar::create($data);
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'name' => 'required|min:1',
            'shipping_goal' => 'required|numeric',
            'shipping_goal_currency' => 'required',
            'link' => 'required_if:add_link,true',
            'expires_days' => 'required_if:add_close_btn,true',
        ]);

        $shippingBar = ShippingBar::find($id);

        $data = $request->all();
        info($data);
        $data['active'] = $request->active;
        $data['add_link'] = $request->add_link;
        $data['add_close_btn'] = $request->add_close_btn;
        $data['currency_conversion'] = $request->currency_conversion;
        $data['shipping_goal_currency_symbol'] = $user->money_format_symbol;
        $data['text_color'] = $request->text_color ? $request->text_color : '#FFFFFF';
        $data['bg_color'] = $request->bg_color ? $request->bg_color : '#000000';
        $data['bg_opacity'] = $request->bg_opacity ? $request->bg_opacity : 100;
        $data['shipping_goal_text_color'] = $request->shipping_goal_text_color ? $request->shipping_goal_text_color : '#ffff00';
        $data['close_btn_color'] = $request->close_btn_color ? $request->close_btn_color : '#ffff00';
        $data['page_targets'] = $request->page_targets;
        $start_at = $request->date_range ? $request->date_range[0] : null;
        $end_at = $request->date_range ? $request->date_range[1] : null;
        $data['start_at'] = $start_at;
        $data['end_at'] = $end_at;
        unset($data['date_range']);
        unset($data['created_at']);

        $shippingBar->update($data);

        return $shippingBar;
    }

    public function upload(Request $request)
    {
        $user = Auth::user();
        $file_name = 'user-' . $user->id . "-" . str_replace('tmp/', "", $request->input('key'));
        Storage::disk('s3')->copy(
            $request->input('key'),
            $file_name
        );
        $url = Storage::disk('s3')->url($file_name);
        $image = UserImage::updateOrCreate(
            [
                'uuid' => $request->input('uuid')
            ],
            [
                'user_id' => $user->id,
                'url' => $url,
                'key' => $request->input('key'),
                'name' => $request->input('name'),
                'bucket' => $request->input('bucket'),
                'content_type' => $request->input('content_type'),
            ]
        );
        return $image;
    }

    public function currencies()
    {
        $currencies = Currency::all();
        return $currencies;
    }

    function customCodes()
    {
        $user = Auth::user();
        $customCodes = ShippingBarCustomCode::where('user_id', $user->id)->first();
        if (!$customCodes) {
            $customCodes = ShippingBarCustomCode::create([
                'user_id' => $user->id,
                'custom_css' => '',
                'custom_js' => ''
            ]);
            return $customCodes;
        }
        return $customCodes;
    }

    function customCss(Request $request)
    {
        $user = Auth::user();
        $customCodes = ShippingBarCustomCode::where('user_id', $user->id)->first();
        if (!$customCodes) {
            $customCodes = ShippingBarCustomCode::create([
                'user_id' => $user->id,
                'custom_css' => $request->custom_css,
                'custom_js' => ''
            ]);
            return $customCodes;
        } else {
            $customCodes->update([
                'custom_css' => $request->custom_css
            ]);
        }
        return $customCodes;
    }

    function customJs(Request $request)
    {
        $user = Auth::user();
        $customCodes = ShippingBarCustomCode::where('user_id', $user->id)->first();
        if (!$customCodes) {
            $customCodes = ShippingBarCustomCode::create([
                'user_id' => $user->id,
                'custom_js' => $request->custom_js,
                'custom_css' => ''
            ]);
            return $customCodes;
        } else {
            $customCodes->update([
                'custom_js' => $request->custom_js
            ]);
        }
        return $customCodes;
    }

    public function statistics()
    {
        $user = Auth::user();
        $total_clicks = ShippingBarClick::where('user_id', $user->id)->count();
        $total_currencies_show = DB::table('shipping_bar_clicks')
            ->select(DB::raw('currency_display'))
            ->where('user_id', $user->id)
            ->groupBy('currency_display')->get()->count();
        return [
            'total_clicks' => $total_clicks,
            'total_currencies_show' => $total_currencies_show
        ];
    }

    public function sessions(Request $request)
    {
        $user = Auth::user();
        $start = $request->start;
        $end = $request->end;
        $stats = DB::table("shipping_bar_stats")->select(DB::raw('currency_display as currency, count(currency_display) as sessions'))
            ->where('user_id', $user->id)
            ->where('stats_at', '>=', $start)
            ->where('stats_at', '<=', $end)
            ->orderByDesc('sessions')
            ->groupBy('currency_display')->get()->toArray();
        return $stats;
    }

    public function clicks(Request $request)
    {
        $user = Auth::user();
        $timezone = $user->iana_timezone;
        if (empty($timezone)) {
            $timezone = 'GMT';
        }
        $start = $request->start;
        $end = $request->end;
        $raw = "DATE(CONVERT_TZ(DATE_FORMAT(FROM_UNIXTIME(stats_at/1000), '%Y-%m-%d %H:%i:%s'), 'GMT', '" . $timezone . "')) as day, count(*) as cc";
        $stats = DB::table("shipping_bar_clicks")->select(DB::raw($raw))
            ->where('user_id', $user->id)
            ->where('stats_at', '>=', $start)
            ->where('stats_at', '<=', $end)
            ->groupBy(DB::raw('day'))->get()->toArray();
        return $stats;
    }

    function hex2rgba($color, $opacity = false, $raw = false)
    {
        $default = 'rgb(0,0,0)';
        //Return default if no color provided
        if (empty($color))
            return $default;
        //Sanitize $color if "#" is provided
        if ($color[0] == '#') {
            $color = substr($color, 1);
        }
        //Check if color has 6 or 3 characters and get values
        if (strlen($color) == 6) {
            $hex = array($color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]);
        } elseif (strlen($color) == 3) {
            $hex = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);
        } else {
            return $default;
        }

        //Convert hexadec to rgb
        $rgb =  array_map('hexdec', $hex);

        if ($raw) {
            if ($opacity) {
                if (abs($opacity) > 1) $opacity = 1.0;
                array_push($rgb, $opacity);
            }
            $output = $rgb;
        } else {
            //Check if opacity is set(rgba or rgb)
            if ($opacity) {
                if (abs($opacity) > 1)
                    $opacity = 1.0;
                $output = 'rgba(' . implode(",", $rgb) . ',' . $opacity . ')';
            } else {
                $output = 'rgb(' . implode(",", $rgb) . ')';
            }
        }

        //Return rgb(a) color string
        return $output;
    }
}
