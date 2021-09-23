@extends('shopify-app::layouts.default')

@section('content')
    <div>
        <!-- You are: (shop domain name) -->
        {{-- <p>You are: {{ Auth::user()->name }}</p> --}}
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div class="flex content-between">
                    <div class="flex flex-1 justify-start">
                        <h1 class="text-3xl font-bold text-gray-900 overflow-hidden whitespace-nowrap">
                            Bars
                        </h1>
                    </div>
                    <div class="flex justify-end">
                        @if (in_array(Auth::user()->plan_id, [2, 4, 5, 6]) || Auth::user()->isGrandfathered())
                            <a href="/fsb/create" class="px-4 py-2 cursor-pointer bg-gray-700 rounded-md text-sm font-mediu hover:bg-gray-900 text-white" aria-current="page">
                                Create
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </header>
        <main>
            <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <!-- Replace with your content -->
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Name
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Preview
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Status
                                            </th>
                                            {{-- <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Role
                                            </th> --}}
                                            <th scope="col" class="relative px-6 py-3">
                                                <span class="sr-only">Edit</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($fsbs as $fsb)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">

                                                        <div class="ml-4">
                                                            <div class="text-sm font-medium text-gray-900">
                                                                {{ $fsb->name }}
                                                            </div>
                                                            <div class="text-sm text-gray-50 bg-gray-400 rounded-full px-3 py-1 mt-2" style="width: 140px;">
                                                                Only you can see
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{-- <div class="text-sm text-gray-900">Regional Paradigm Technician</div>
                                                    <div class="text-sm text-gray-500">Optimization</div> --}}
                                                    <div class="text-sm flex flex-col space-y-2">
                                                        <div class="flex relative h-10 rounded opacity-{{$fsb->bg_opacity}}"
                                                            style="background: {{$fsb->bg_image ? 'transparent' : $fsb->bg_color}}"
                                                            >
                                                            @if ($fsb->bg_image)
                                                                <div class="absolute rounded w-full h-10 top-0 left-0 z-0" >
                                                                    <img style="opacity: {{number_format($fsb->bg_opacity/100, 2)}}" class="object-cover rounded w-full h-10" src="{{$fsb->bg_image}}" alt="">
                                                                </div>
                                                            @endif
                                                            <div class="flex relative justify-center rounded leading-8 py-1 w-full h-10 z-10">
                                                                <div style="color: {{$fsb->text_color}}">{{ $fsb->init_message_1 }} </div>
                                                                <div class="px-2" style="color: {{$fsb->shipping_goal_text_color }}">{{ $fsb->shipping_goal_currency_symbol }}{{ $fsb->shipping_goal }}</div>
                                                                <div style="color: {{$fsb->text_color}}">{{ $fsb->init_message_2 }}</div>
                                                                @if ($fsb->add_close_btn)
                                                                    <div class="absolute top-3 right-3 w-4 h-4" style="color: {{$fsb->close_btn_color}}">
                                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="flex relative h-10 rounded opacity-{{$fsb->bg_opacity}}" style="background: {{$fsb->bg_image ? 'transparent' : $fsb->bg_color}}">
                                                            @if ($fsb->bg_image)
                                                                <div class="absolute rounded w-full h-10 top-0 left-0 z-0">
                                                                    <img style="opacity: {{number_format($fsb->bg_opacity/100, 2)}}" class="object-cover rounded w-full h-10" src="{{$fsb->bg_image}}" alt="">
                                                                </div>
                                                            @endif
                                                            <div class="flex relative justify-center rounded leading-8 py-1 w-full h-10 z-10">
                                                                <div style="color: {{$fsb->text_color}}">{{ $fsb->progress_message_1 }} </div>
                                                                <div class="px-2" style="color: {{$fsb->shipping_goal_text_color }}">{{ $fsb->shipping_goal_currency_symbol }}{{ $fsb->shipping_goal }}</div>
                                                                <div style="color: {{$fsb->text_color}}">{{ $fsb->progress_message_2 }}</div>
                                                                @if ($fsb->add_close_btn)
                                                                    <div class="absolute top-3 right-3 w-4 h-4" style="color: {{$fsb->close_btn_color}}">
                                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="flex relative h-10 rounded opacity-{{$fsb->bg_opacity}}" style="background: {{$fsb->bg_image ? 'transparent' : $fsb->bg_color}}">
                                                            @if ($fsb->bg_image)
                                                                <div class="absolute rounded w-full h-10 top-0 left-0 z-0">
                                                                    <img style="opacity: {{number_format($fsb->bg_opacity/100, 2)}}" class="object-cover rounded w-full h-10" src="{{$fsb->bg_image}}" alt="">
                                                                </div>
                                                            @endif
                                                            <div class="flex relative justify-center rounded leading-8 py-1 w-full h-10 z-10">
                                                                <div style="color: {{$fsb->text_color}}">{{ $fsb->achieved_message_1 }} </div>
                                                                {{-- <div class="px-2" style="color: {{$fsb->shipping_goal_text_color }}">{{ $fsb->shipping_goal_currency_symbol }}{{ $fsb->shipping_goal }}</div> --}}
                                                                <div style="color: {{$fsb->text_color}}">{{ $fsb->achieved_message_2 }}</div>
                                                                @if ($fsb->add_close_btn)
                                                                    <div class="absolute top-3 right-3 w-4 h-4" style="color: {{$fsb->close_btn_color}}">
                                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if ($fsb->active)
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                            Active
                                                        </span>
                                                    @else
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-400">
                                                            Draft
                                                        </span>
                                                    @endif
                                                </td>
                                                {{-- <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    Admin
                                                </td> --}}
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <a href="/fsb/{{$fsb->id}}/edit" class="text-indigo-600 hover:text-indigo-900" aria-current="page">Edit</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
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
            title: 'Bars',
        };
        var myTitleBar = TitleBar.create(app, titleBarOptions);
    </script>
@endsection

@section('styles')

@endsection
