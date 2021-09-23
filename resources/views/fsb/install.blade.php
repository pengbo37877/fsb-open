@extends('shopify-app::layouts.default')

@section('content')
    <div>
        <!-- You are: (shop domain name) -->
        {{-- <p>You are: {{ Auth::user()->name }}</p> --}}
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900">
                Install instructions
            </h1>
            </div>
        </header>
        <main>
            <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <!-- Replace with your content -->
                <div class="mx-10 p-10 flex flex-col space-y-3">
                    <div class="rounded-xl shadow h-8">
                        <img src="{{asset('image/bar002.png')}}" class="rounded-xl h-10 w-full object-cover">
                    </div>
                    <div class="rounded-xl shadow h-8">
                        <img src="{{asset('image/bar017.jpeg')}}" class="rounded-xl h-10 w-full object-cover">
                    </div>
                    <div class="rounded-xl shadow h-8">
                        <img src="{{asset('image/bar020.png')}}" class="rounded-xl h-10 w-full object-cover">
                    </div>
                    <div class="rounded-xl shadow h-8">
                        <img src="{{asset('image/bar023.jpeg')}}" class="rounded-xl h-10 w-full object-cover">
                    </div>
                </div>
                <a href="/plan">Plan</a>
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
            title: 'Install instructions',
        };
        var myTitleBar = TitleBar.create(app, titleBarOptions);
    </script>
@endsection

@section('styles')

@endsection
