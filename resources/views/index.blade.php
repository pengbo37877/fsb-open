@extends('shopify-app::layouts.default')

@section('content')
    <div>
        <!-- You are: (shop domain name) -->
        {{-- <p>You are: {{ Auth::user()->name }}</p> --}}
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900">
                Dashboard
            </h1>
            </div>
        </header>
        <main>
            <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <!-- Replace with your content -->
                <!-- This example requires Tailwind CSS v2.0+ -->
                @if (Auth::user()->plan_id != 1 && Auth::user()->plan_id != 3 && !Auth::user()->isGrandfathered())
                    <metrics-info></metrics-info>
                @endif

                <div class="mt-4 bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Account Information
                        </h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                        Personal details and plans.
                        </p>
                    </div>
                    <div class="border-t border-gray-200">
                        <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                            Your Shop
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ Auth::user()->name }}
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                            Your Plan
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ Auth::user()->plan->name }}
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                            Your Plan Features
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 flex">
                            @if ((Auth::user()->plan_id == 1 || Auth::user()->plan_id == 3) && !Auth::user()->isGrandfathered())
                                <div class="w-1/2">
                                    <li>Fully customizable banner</li>
                                    <li>Display at any desired position</li>
                                    <li>Device targeting</li>
                                    <li>Page targeting</li>
                                    <li>Option to add link to the bar</li>
                                    <li>Option to add close button to the bar</li>
                                    <li>Emoji support on bar</li>
                                </div>

                                <div class="p-4 w-1/2 border-gray-400 bg-gray-400 shadow-md rounded-lg">
                                    <p class="text-gray-800 font-bold mb-2">more features for upgrade</p>
                                    <div>
                                        <li>Unlimited active bars</li>
                                        <li>Auto currency conversion</li>
                                        <li>Bar background images</li>
                                        <li>Auto scheduling</li>
                                        <li>Performance tracking</li>
                                    </div>
                                    <div class="mt-4 flex flex-col space-y-3" style="width: fit-content">
                                    @if(Auth::user()->plan_id == 3)
                                        <a class="ml-4 bg-gray-800 text-white rounded-md shadow-sm px-4 py-2" href="{{ route('billing', ['plan' => 4]) }}">Upgrade monthly $5.99 / month</a>
                                        <a class="ml-4 bg-gray-800 text-white rounded-md shadow-sm px-4 py-2" href="{{ route('billing', ['plan' => 5]) }}">Upgrade yearly $59.9 / year</a>
                                    @elseif(Auth::user()->plan_id == 1)
                                        <a class="ml-4 bg-gray-800 text-white rounded-md shadow-sm px-4 py-2" href="{{ route('billing', ['plan' => 2]) }}">Upgrade monthly $5.99 / month</a>
                                        <a class="ml-4 bg-gray-800 text-white rounded-md shadow-sm px-4 py-2" href="{{ route('billing', ['plan' => 6]) }}">Upgrade yearly $59.9 / year</a>
                                    @endif
                                    </div>
                                </div>
                            @elseif(Auth::user()->plan_id == 2)
                                <div class="w-1/2">
                                    <li>Fully customizable banner</li>
                                    <li>Display at any desired position</li>
                                    <li>Device targeting</li>
                                    <li>Page targeting</li>
                                    <li>Option to add link to the bar</li>
                                    <li>Option to add close button & set expires time</li>
                                    <li>Emoji support on bar</li>
                                    <li>Unlimited active bars</li>
                                    <li>Auto currency conversion</li>
                                    <li>Bar background images</li>
                                    <li>Auto scheduling</li>
                                    <li>Performance tracking</li>
                                </div>
                                <div class="p-4 w-1/2 border-gray-400 bg-gray-400 shadow-md rounded-lg">
                                    <p class="text-gray-800 font-bold mb-2">more plans for downgrade</p>
                                    <div class="flex flex-col space-y-3" style="width: fit-content">
                                        <a class="ml-4 bg-gray-800 text-gray-50 rounded-md shadow-sm px-4 py-2" href="{{ route('billing', ['plan' => 1]) }}">Downgrade free plan</a>
                                        <a class="ml-4 bg-gray-800 text-gray-50 rounded-md shadow-sm px-4 py-2" href="{{ route('billing', ['plan' => 6]) }}">Upgrade yearly $59.9 / year</a>
                                    </div>
                                </div>
                            @elseif(Auth::user()->plan_id == 6)
                                <div class="w-1/2">
                                    <li>Fully customizable banner</li>
                                    <li>Display at any desired position</li>
                                    <li>Device targeting</li>
                                    <li>Page targeting</li>
                                    <li>Option to add link to the bar</li>
                                    <li>Option to add close button & set expires time</li>
                                    <li>Emoji support on bar</li>
                                    <li>Unlimited active bars</li>
                                    <li>Auto currency conversion</li>
                                    <li>Bar background images</li>
                                    <li>Auto scheduling</li>
                                    <li>Performance tracking</li>
                                </div>
                                <div class="p-4 w-1/2 border-gray-400 bg-gray-400 shadow-md rounded-lg">
                                    <p class="text-gray-800 font-bold mb-2">more plans for downgrade</p>
                                    <div class="flex flex-col space-y-3" style="width: fit-content">
                                        <a class="ml-4 bg-gray-800 text-gray-50 rounded-md shadow-sm px-4 py-2" href="{{ route('billing', ['plan' => 1]) }}">Downgrade free plan</a>
                                        <a class="ml-4 bg-gray-800 text-gray-50 rounded-md shadow-sm px-4 py-2" href="{{ route('billing', ['plan' => 2]) }}">Downgrand monthly $5.99 / month</a>
                                    </div>
                                </div>
                            @elseif (Auth::user()->plan_id == 4 && !Auth::user()->isGrandfathered())
                                <div class="w-1/2">
                                    <li>Fully customizable banner</li>
                                    <li>Display at any desired position</li>
                                    <li>Device targeting</li>
                                    <li>Page targeting</li>
                                    <li>Option to add link to the bar</li>
                                    <li>Option to add close button to the bar</li>
                                    <li>Emoji support on bar</li>
                                    <li>Unlimited active bars</li>
                                    <li>Auto currency conversion</li>
                                    <li>Bar background images</li>
                                    <li>Auto scheduling</li>
                                    <li>Performance tracking</li>
                                </div>
                                <div class="p-4 w-1/2 border-gray-400 bg-gray-400 shadow-md rounded-lg">
                                    <p class="text-gray-800 font-bold mb-2">more plans for downgrade/upgrade</p>
                                    <div class="flex flex-col space-y-3" style="width: fit-content">
                                        <a class="ml-4 bg-gray-500 text-gray-50 rounded-md shadow-sm px-4 py-2" href="{{ route('billing', ['plan' => 3]) }}">Downgrade free</a>
                                        <a class="ml-4 bg-gray-800 text-gray-50 rounded-md shadow-sm px-4 py-2" href="{{ route('billing', ['plan' => 5]) }}">Upgrade yearly $59.9 / year</a>
                                    </div>
                                </div>
                            @elseif (Auth::user()->plan_id == 5 && !Auth::user()->isGrandfathered())
                                <div class="w-1/2">
                                    <li>Fully customizable banner</li>
                                    <li>Display at any desired position</li>
                                    <li>Device targeting</li>
                                    <li>Page targeting</li>
                                    <li>Option to add link to the bar</li>
                                    <li>Option to add close button to the bar</li>
                                    <li>Emoji support on bar</li>
                                    <li>Unlimited active bars</li>
                                    <li>Auto currency conversion</li>
                                    <li>Bar background images</li>
                                    <li>Auto scheduling</li>
                                    <li>Performance tracking</li>
                                </div>
                                <div class="p-4 w-1/2 border-gray-400 bg-gray-400 shadow-md rounded-lg">
                                    <p class="text-gray-800 font-bold mb-2">plans for downgrade</p>
                                    <div class="flex flex-col space-y-3" style="width: fit-content">
                                        <a class="ml-4 bg-gray-500 text-gray-50 rounded-md shadow-sm px-4 py-2" href="{{ route('billing', ['plan' => 3]) }}">Downgrade free</a>
                                        <a class="ml-4 bg-gray-500 text-gray-50 rounded-md shadow-sm px-4 py-2" href="{{ route('billing', ['plan' => 4]) }}">Downgrade monthly $5.99 / month</a>
                                    </div>
                                </div>
                            @elseif(Auth::user()->isGrandfathered())
                                <div class="p-4">
                                    <p class="text-gray-800 font-bold mb-2">Your are Grandfatherd user. all features are opening, please enjoy!</p>
                                </div>
                            @endif
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                            Contact us
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{-- If this is your first use FreeShippingBar by PB. please goto <a class="text-blue-700 underline" href="/install">install</a>
                            for instructions. <br> --}}
                            For more help, your can contact <a class="text-blue-700 underline" target="_blank" href="mailto:pengbo37877@gmail.com?subject=[FSB] {{ Auth::user()->name }} for help">pengbo37877@gmail.com</a>.
                            </dd>
                        </div>
                        </dl>
                    </div>
                </div>
                <shop-info></shop-info>
            <!-- /End replace -->
            </div>
        </main>
    </div>
@endsection

@section('scripts')
    @parent
    <script type="text/javascript">
        var AppBridge = window['app-bridge'];
        var actions = AppBridge.actions;
        var TitleBar = actions.TitleBar;
        var Button = actions.Button;
        var Redirect = actions.Redirect;
        var titleBarOptions = {
            title: 'Dashboard',
        };
        var myTitleBar = TitleBar.create(app, titleBarOptions);
    </script>
@endsection

@section('styles')

@endsection
