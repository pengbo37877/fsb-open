<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Osiset\ShopifyApp\Actions\GetPlanUrl;
use Illuminate\Contracts\View\View as ViewView;
use Illuminate\Support\Facades\Auth;
use Osiset\ShopifyApp\Objects\Values\NullablePlanId;

class BillingController extends Controller
{

    public function index(?int $plan = null, GetPlanUrl $getPlanUrl)
    {
    	$user = Auth::user();
        // Get the plan URL for redirect
        if($user) {
	        $url = $getPlanUrl(
	            $user->getId(),
	            NullablePlanId::fromNative($plan)
	        );

	        return $url;
	    }
	    return "";
    }
}
