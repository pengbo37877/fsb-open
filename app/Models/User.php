<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Osiset\ShopifyApp\Contracts\ShopModel as IShopModel;
use Osiset\ShopifyApp\Traits\ShopModel;


class User extends Authenticatable implements IShopModel
{
    use HasFactory, Notifiable;
    use ShopModel;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'contact_email',
        'country',
        'country_code',
        'country_name',
        'currency',
        'enabled_presentment_currencies',
        'money_format',
        'money_in_emails_format',
        'money_with_currency_format',
        'money_with_currency_in_emails_format',
        'money_format_symbol',
        'iana_timezone',
        'shopify_plan_name',
        'password',
        'shopify_grandfathered',
        'shopify_namespace',
        'shopify_freemium',
        'plan_id',
        'shop_id',
        'shopify_response'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        // 'enabled_presentment_currencies' => 'array'
        'shopify_response' => 'json'
    ];

    public function bars()
    {
        return $this->hasMany(ShippingBar::class);
    }
}
