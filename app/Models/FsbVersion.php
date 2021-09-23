<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FsbVersion extends Model
{
    use HasFactory;

    protected $guarded = false;

    const ENV_DEVELOPMENT = 'dev';
    const ENV_PRODUCTION = 'prod';
}
