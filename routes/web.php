<?php

use App\Http\Controllers\BillingController;
use App\Http\Controllers\PddController;
use App\Http\Controllers\ShippingBarController;
use App\Http\Controllers\ShopifyController;
use App\Http\Controllers\SpaController;
use App\Http\Controllers\SignedStorageUrlController;
use App\Models\ShippingBar;
use App\Models\User;
use App\Models\UserImage;
use App\Models\Currency;
use App\Models\ShippingBarCustomCode;
use App\Models\ShopifyCurrency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// spa home
Route::get('/', function () {
    $user = Auth::user();
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
        'shopify_response' => $shopApi
    ]);
    return view("spa");
})->middleware(['verify.shopify'])->name('home');

Route::get('/plan', [ShopifyController::class, 'plan'])->middleware(['verify.shopify'])->name('plan');
Route::get('/shop', [ShopifyController::class, 'index'])->middleware(['verify.shopify'])->name('shop');
Route::get('/create_first_fsb', [ShopifyController::class, 'create_first_fsb'])->middleware(['verify.shopify'])->name('create_first_fsb');

// app front api
Route::get('fsb', [ShippingBarController::class, 'index'])->middleware(['verify.shopify'])->name('fsb.index');
Route::get('fsb/create', [ShippingBarController::class, 'create'])->middleware(['verify.shopify'])->name('fsb.create');
Route::post('fsb', [ShippingBarController::class, 'store'])->middleware(['verify.shopify'])->name('fsb.store');
Route::put('fsb/{id}', [ShippingBarController::class, 'update'])->middleware(['verify.shopify'])->name('fsb.update');
Route::delete('fsb/{id}', [ShippingBarController::class, 'destroy'])->middleware(['verify.shopify'])->name('fsb.destroy');
Route::get('fsb/{id}/edit', [ShippingBarController::class, 'edit'])->middleware(['verify.shopify'])->name('fsb.edit');
Route::get('install', [ShippingBarController::class, 'install'])->middleware(['verify.shopify']);
Route::post('upload', [ShippingBarController::class, 'upload'])->middleware(['verify.shopify']);

Route::get('metrics_traffic_past_hour', [ShippingBarController::class, 'metrics_traffic_past_hour'])->middleware(['verify.shopify']);
Route::get('metrics_avg_timing_past_hour', [ShippingBarController::class, 'metrics_avg_timing_past_hour'])->middleware(['verify.shopify']);

// guide
Route::get('/how-to-custom-placement', function () {
    return view('how-to-custom-placement');
});

// spa view routes
Route::get('anti', function () {
    return view('spa');
});
Route::get('anti/create', function () {
    return view('spa');
});
Route::get('anti/{id}/edit', function () {
    return view('spa');
});
Route::get('custom', function () {
    return view('spa');
});
Route::get('performance', function () {
    return view('spa');
});
// spa data routes
Route::get('/spa/user', function (Request $request) {
    $user = Auth::user();
    $u = User::with('plan')->find($user->id);
    $u->enabled_presentment_currencies = json_decode($u->enabled_presentment_currencies);
    return $u;
})->middleware(['verify.shopify']);

Route::get('/spa/images', function (Request $request) {
    $user = Auth::user();
    return UserImage::where('user_id', $user->id)->get();
})->middleware(['verify.shopify']);

Route::get('/spa/shop', function (Request $request) {
    $shop = Auth::user();
    $domain = $shop->getDomain()->toNative();
    $shopApi = $shop->api()->rest('GET', '/admin/shop.json')['body']['shop'];
    return json_encode($shopApi);
})->middleware(['verify.shopify']);

Route::get('/spa/fsbs', [SpaController::class, 'fsbs'])->middleware(['verify.shopify']);
Route::post('/spa/fsbs', [SpaController::class, 'store'])->middleware(['verify.shopify']);
Route::get('/spa/fsb/{id}', [SpaController::class, 'fsb'])->middleware(['verify.shopify']);
Route::put('/spa/fsb/{id}', [SpaController::class, 'update'])->middleware(['verify.shopify']);
Route::post('/spa/upload', [SpaController::class, 'upload'])->middleware(['verify.shopify']);
Route::get('/spa/currencies', [SpaController::class, 'currencies'])->middleware(['verify.shopify']);
Route::get('/spa/custom_codes', [SpaController::class, 'customCodes'])->middleware(['verify.shopify']);
Route::put('/spa/custom_css', [SpaController::class, 'customCss'])->middleware(['verify.shopify']);
Route::put('/spa/custom_js', [SpaController::class, 'customJs'])->middleware(['verify.shopify']);
Route::get('/spa/statistics', [SpaController::class, 'statistics'])->middleware(['verify.shopify']);
Route::get('/spa/sessions', [SpaController::class, 'sessions'])->middleware(['verify.shopify']);
Route::get('/spa/clicks', [SpaController::class, 'clicks'])->middleware(['verify.shopify']);
Route::post('/spa/store-url', [SignedStorageUrlController::class, 'store'])->middleware(['verify.shopify']);

Route::get('/spa/billing/{plan?}', [BillingController::class, 'index'])->middleware(['verify.shopify']);


// shopify store front api
Route::get('/pdd/scripttags/{name}', function (Request $request, $name) {
    $shop = $request->shop;
    $user = User::where('name', $shop)->first();
    if (!$user) {
        return '';
    }
    $customCode = ShippingBarCustomCode::where('user_id', $user->id)->first();
    if (!$customCode) {
        $customCode = [
            'custom_css' => '',
            'custom_js' => ''
        ];
    }
    $script = file_get_contents(env('APP_URL') . "/js/" . $name);
    $shopifyCurrency = ShopifyCurrency::latest()->first()->body;
    $currencies = Currency::all();
    return "var pddShopDomain='" . $shop . "';\r\n" . "var pddBaseUrl='" . env('APP_URL') . "';\r\n" .
        "var shopCurrency='" . $user->currency . "';\r\n" .
        $shopifyCurrency . "\r\n" .
        "var currencies=" . $currencies . ";\r\n" .
        "var pddCustomCode=" . $customCode . ";\r\n" .
        $script;
});
Route::get('/pdd/ip', [PddController::class, 'ip']);
Route::get('/pdd/shop', [PddController::class, 'shop']);
Route::get('/pdd/shippingbar', [PddController::class, 'shippingbar']);
Route::get('/pdd/performance', [PddController::class, 'performance']);
Route::post('/pdd/stats', [PddController::class, 'stats']);
Route::post('/pdd/click', [PddController::class, 'click']);

Route::get('/policy', function () {
    return view('policy');
});
