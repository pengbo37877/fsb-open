@extends('shopify-app::layouts.default')

@section('content')
    <div id="app">
        <router-view></router-view>
    </div>
@endsection

@section('scripts')
    @parent
    <script type="text/javascript">

    </script>
@endsection
