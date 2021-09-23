@extends('shopify-app::layouts.default')

@section('content')
    <div>
        <create-free-shipping-bar :user="{{$user}}"  :shipping-bar="{{$bar}}" :images="{{$images}}"></-free-shipping-bar>
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
            title: 'Edit',
        };
        var myTitleBar = TitleBar.create(app, titleBarOptions);
    </script>
@endsection
