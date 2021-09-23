<?php

namespace App\Models;

use DateTime;
use DateTimeZone;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class ShippingBar extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = false;

    protected $casts = [
        'currency_conversion' => 'boolean',
        'add_link' => 'boolean',
        'add_close_btn' => 'boolean',
        'active' => 'boolean'
    ];

    const CREATED_BY_FSB = 'fsb';
    const CREATED_BY_USER = 'user';
}
