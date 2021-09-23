<?php

namespace App\Jobs;

use App\Models\Currency;
use App\Models\ShippingBar;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class AfterAuthorizeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public User $shop;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($shop)
    {
        $this->shop = $shop;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        info('鉴权成功 ' . $this->shop->name);
        $ffsb = ShippingBar::where('user_id', $this->shop->id)->first();
        if(!$ffsb) {
            DB::transaction(function () {
                $this->firstFreeShippingBar($this->shop);
            });
        }
    }

    function updateUser($user) {
        $shopApi = $user->api()->rest('GET', '/admin/shop.json')['body']['shop'];
        $currency = Currency::where('currency', $shopApi->currency)->first();
        $money_symbol = "";
        if ($currency) {
            $money_symbol = $currency->currency_symbol;
        }
        $user->update([
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
    }

    function firstFreeShippingBar($user)
    {
        return ShippingBar::create([
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
            'bg_image' => "https://warm-hill-eiwfidlwac1y.vapor-farm-d1.com/image/bar023.jpeg",
            'text_color' => '#ffffff',
            'shipping_goal_text_color' => '#ffff00',
            'display_position' => 'TOP',
            'add_close_btn' => 1,
            'close_btn_color' => '#ffffff',
            'active' => 1,
            'expires_days' => 1,
            'geo_targets' => "[]",
            'page_targets' => '["404","article","blog","cart","collection","list-collections","customers\/account","customers\/activate_account","customers\/addresses","customers\/login","customers\/order","customers\/register","customers\/reset_password","gift_card","index","page","password","product","search"]',
            'created_by' => ShippingBar::CREATED_BY_FSB,
            'timezone' => '',
            'font' => 'Overpass',
            'font_size' => '16px',
            'height' => '40px'
        ]);
    }
}
