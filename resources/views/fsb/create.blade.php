@extends('shopify-app::layouts.default')

@section('content')
    <div>
        <create-free-shipping-bar :user="{{$user}}" :images="{{$images}}"></create-free-shipping-bar>
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
            title: 'Create',
        };
        var myTitleBar = TitleBar.create(app, titleBarOptions);
    </script>
@endsection

@section('styles')

@endsection
