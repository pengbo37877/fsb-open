<?php

namespace App\Http\Controllers;

use App\Models\FsbVersion;
use App\Models\ShippingBar;
use App\Models\Theme;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Osiset\ShopifyApp\Services\ChargeHelper;

class ShopifyController extends Controller
{

    public function index()
    {
        $shop = Auth::user();
        $domain = $shop->getDomain()->toNative();
        $shopApi = $shop->api()->rest('GET', '/admin/shop.json')['body']['shop'];

        info("Shop {$domain}'s object:" . json_encode($shop));
        info("Shop {$domain}'s API objct:" . json_encode($shopApi));
        $currency = Currency::where('currency', $shopApi->currency)->first();
        $money_symbol = "";
        if ($currency) {
            $money_symbol = $currency->currency_symbol;
        }
        $shop->update([
            'contact_email' => $shopApi->email,
            'country' => $shopApi->country,
            'country_code' => $shopApi->country_code,
            'country_name' => $shopApi->country_name,
            'currency' => $shopApi->currency,
            'enabled_presentment_currencies' => json_encode($shopApi->enabled_presentment_currencies),
            'money_format' => $shopApi->money_format,
            'money_with_currency_format' => $shopApi->money_with_currency_format,
            'money_in_emails_format' => $shopApi->money_in_emails_format,
            'money_with_currency_in_emails_format' => $shopApi->money_with_currency_in_emails_format,
            'money_format_symbol' => $money_symbol,
            'iana_timezone' => $shopApi->iana_timezone,
            'shopify_plan_name' => $shopApi->plan_name,
            'shop_id' => $shopApi->id,
        ]);
        return json_encode($shopApi);
    }

    public function plan()
    {
        $shop = Auth::user();
        if(empty($shop->plan_id)) {
            return [];
        }
        $chargeHelper = app()->make(ChargeHelper::class);
        $charge = $chargeHelper->chargeForPlan($shop->plan->getId(), $shop);
        $chargeApi = $chargeHelper->useCharge($charge->getReference())->retrieve($shop);
        return $chargeApi;
    }


    public function create_first_fsb(Request $request)
    {
        $user = Auth::user();
        $first_fsb = ShippingBar::where('user_id', $user->id)->first();
        if ($first_fsb) {
            return response()->json([
                'message' => 'already has one.'
            ]);
        }
        $timezone = $request->timezone;
        $first_fsb = ShippingBar::create([
            'user_id' => $user->id,
            'name' => 'Free Shipping Bar',
            'shipping_goal' => 100,
            'shipping_second_goal' => 0,
            'shipping_goal_currency' => $user->currency,
            'shipping_goal_currency_symbol' => $user->money_format_symbol,
            'init_message_1' => 'Free shipping for all orders over',
            'progress_message_1' => 'Only',
            'progress_message_2' => 'away from free shipping',
            'achieved_message_1' => "Congratulations! You've got free shipping",
            'bg_color' => '#9900ff',
            'bg_opacity' => 100,
            'text_color' => '#ffffff',
            'shipping_goal_text_color' => '#ffff00',
            'display_position' => 'TOP',
            'add_close_btn' => 1,
            'close_btn_color' => '#ffffff',
            'active' => 0,
            'expires_days' => 1,
            'page_targets' => '["404","article","blog","cart","collection","list-collections","customers\/account","customers\/activate_account","customers\/addresses","customers\/login","customers\/order","customers\/register","customers\/reset_password","gift_card","index","page","password","product","search"]',
            'created_by' => ShippingBar::CREATED_BY_FSB,
            'timezone' => $timezone,
            'font' => 'Overpass',
            'font_size' => '16px',
            'height' => '40px'
        ]);
        return $first_fsb;
    }
}
