<?php

namespace App\Http\Controllers;

use App\Models\PerformanceTraking;
use App\Models\ShippingBar;
use App\Models\UserImage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

class ShippingBarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $fsbs = ShippingBar::where('user_id', $user->id)->get(); // 所有bar
        foreach ($fsbs as $fsb) {
            // 颜色转换
            if (!$fsb->bg_image) {
                $fsb->bg_color = $this->hex2rgba($fsb->bg_color, $fsb->bg_opacity / 100);
            }
        }
        return view('fsb.index', compact('fsbs'));
        // $contents = View::make('fsb.index', compact('fsbs'));
        // $response = Response::make($contents, 200);
        // $response->header('Content-Security-Policy', 'frame-ancestors ' . $user->name);
        // return $response;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $images = UserImage::where('user_id', $user->id)->get();
        return view('fsb.create', compact('user', 'images'));
        // $contents = View::make('fsb.create', compact('user', 'images'));
        // $response = Response::make($contents, 200);
        // $response->header('Content-Security-Policy', 'frame-ancestors ' . $user->name);
        // return $response;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $plan = $user->plan;

        $validated = $request->validate([
            'name' => 'required|min:1',
            'shipping_goal' => 'required|numeric',
            'shipping_goal_currency' => 'required',
            'link' => 'required_if:add_link,1',
            'expires_days' => 'required_if:add_close_btn,1',
        ]);
        $data = $request->all();
        $data['user_id'] = $user->id;
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ShippingBar  $shippingBar
     * @return \Illuminate\Http\Response
     */
    public function show(ShippingBar $shippingBar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ShippingBar  $shippingBar
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Auth::user();
        $bar = ShippingBar::find($id);
        if ($bar && $bar->start_at) {
            $bar['date_range'] = [
                strlen($bar->start_at) == 13 ? $bar->start_at : $bar->start_at * 1000,
                strlen($bar->end_at) == 13 ? $bar->end_at : $bar->end_at * 1000,
            ];
        }
        if ($bar && $bar->page_targets) {
            $bar['page_targets'] = json_decode($bar->page_targets, true);
        }
        $images = UserImage::where('user_id', $user->id)->get();
        return view('fsb.edit', compact('user', 'bar', 'images'));
        // $contents = View::make('fsb.edit', compact('user', 'bar', 'images'));
        // $response = Response::make($contents, 200);
        // $response->header('Content-Security-Policy', 'frame-ancestors ' . $user->name);
        // return $response;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ShippingBar  $shippingBar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'name' => 'required|min:1',
            'shipping_goal' => 'required|numeric',
            'shipping_goal_currency' => 'required',
            'link' => 'required_if:add_link,1',
            'expires_days' => 'required_if:add_close_btn,1',
        ]);

        $shippingBar = ShippingBar::find($id);

        $data = $request->all();
        info($data);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ShippingBar  $shippingBar
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShippingBar $shippingBar)
    {
        //
    }

    public function metrics_traffic_past_hour()
    {
        $user = Auth::user();

        $count = PerformanceTraking::where('user_id', $user->id)->where('created_at', '>', Carbon::now()->subHour())->count();
        return $count;
    }

    public function metrics_avg_timing_past_hour()
    {
        $user = Auth::user();

        $avg = PerformanceTraking::where('user_id', $user->id)->where('created_at', '>', Carbon::now()->subHour())->avg("time");
        return $avg;
    }

    public function install(Request $request)
    {
        return view('fsb.install');
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
