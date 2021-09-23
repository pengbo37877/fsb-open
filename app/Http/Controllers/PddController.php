<?php

namespace App\Http\Controllers;

use App\Models\PerformanceTraking;
use App\Models\ShippingBar;
use App\Models\User;
use App\Models\ShippingBarStats;
use App\Models\ShippingBarClick;
use Illuminate\Http\Request;

class PddController extends Controller
{
    public function scripttags()
    {
        $js = env('APP_URL') . "/scripttags/dummy.js";
        return file_get_contents($js);
    }

    public function ip(Request $request) {
        $shopDomain = $request->shop;
        if (!$shopDomain) {
            return [];
        }
        // $user = User::where('name', $shopDomain)->first();
        $data = file_get_contents('http://www.geoplugin.net/json.gp?ip=' . $request->ip());
        info("from ip=".$request->ip()." fetch data=".$data);
        return $data;
    }

    public function shop(Request $request)
    {
        $shop = $request->shop;
        $user = User::where('name', $shop)->first();
        return response()->json($user);
    }

    public function shippingbar(Request $request)
    {
        $shop = $request->shop;
        $pageType = $request->pageType;
        $time = $request->time;

        $logInfo = $request->all();
        $logInfo['ip'] = $request->ip();
        info($logInfo);

        $user = User::where('name', $shop)->first();
        if(!$user) {
            return [];
        }

        // 从pathname中提取page type
        $contains_slash = str_contains($pageType, '/');
        if ($contains_slash) {
            $pageType = explode('/', $pageType)[1];
        }
        // 这里做转换
        if($pageType == "products") {
            $pageType = "product";
        }
        //TODO 这里要考虑用户付费情况

        $bars = ShippingBar::where('user_id', $user->id)->where('active', 1)
            ->where('page_targets', 'like', '%' . $pageType . '%')
            ->where(function ($query) use ($time) {
                $query->where('start_at', '<=', $time)->orWhere('start_at', null);
            })
            ->where(function ($query) use ($time) {
                $query->where('end_at', '>=', $time)->orWhere('end_at', null);
            })
            ->get();
        // geo targets
        foreach ($bars as $bar) {
            $bar->geo_targets = json_decode($bar->geo_targets);
        }

        return $bars;
    }

    public function performance(Request $request)
    {
        $shop = $request->shop;
        $user = User::where('name', $shop)->first();
        $ip = $_SERVER['REMOTE_ADDR'];
        $time = $request->time;
        $type = $request->type;
        $path = $request->path;
        $timezone = $request->timezone;
        $p = PerformanceTraking::create([
            'user_id' => $user->id,
            'ip' => $request->ip(),
            'time' => $time,
            'page_type' => $type,
            'page_path' => $path,
            'timezone' => $timezone,
        ]);
        return $p;
    }

    public function stats(Request $request) {
        $shopDomain = $request->shop;
        $user = User::where('name', $shopDomain)->first();
        if(!$user) return "";
        if(empty($request->client_id)) return "";
        $stats = ShippingBarStats::updateOrCreate(
            [
                'client_id' => $request->client_id
            ],
            [
                'user_id' => $user->id,
                'ip' => $request->ip(),
                'currency_display' => $request->currency_display,
                'currency_location' => $request->currency_location,
                'location_timestamp' => $request->location_timestamp,
                'ban_bar_ids' => $request->ban_bar_ids,
                'ban_bar_times' => $request->ban_bar_times,
                'from' => $request->from,
                'stats_at' => $request->stats_at
        ]);
        if ($request->from === 'click') {
            $stats->increment('click_times');
        }
        return $stats;
    }

    public function click(Request $request) {
        $shopDomain = $request->shop;
        $user = User::where('name', $shopDomain)->first();
        if(!$user) return "";
        if(empty($request->client_id)) return "";
        $click = ShippingBarClick::create([
                    'user_id' => $user->id,
                    'client_id' => $request->client_id,
                    'ip' => $request->ip(),
                    'currency_display' => $request->currency_display,
                    'currency_location' => $request->currency_location,
                    'location_timestamp' => $request->location_timestamp,
                    'ban_bar_ids' => $request->ban_bar_ids,
                    'ban_bar_times' => $request->ban_bar_times,
                    'bar_id' => $request->bar_id,
                    'stats_at' => $request->stats_at
                ]);
        return $click;
    }
}
