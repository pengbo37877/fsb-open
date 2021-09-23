<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <title>Ant Free Shipping Bar</title>
    </head>

    <body class="bg-gray-100">
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2">
                <div class="lg:col-span-1 col-span-2">
                    <div class="flex flex-col">
                        <div class="text-3xl text-gray-800">How to placement the custom bar</div>
                        {{-- step1 --}}
                        <div class="mt-4 rounded shadow p-4 bg-white flex flex-col">
                            <div class="font-bold text-gray-800">Step 1/4</div>
                            <div class="mt-4 font-light text-gray-800">
                                Change "Display position on the page" to "CUSTOM" and click "save"
                            </div>
                            <div class="mt-4">
                                <img src="{{ asset('image/fsb_step1.png') }}" alt="">
                            </div>
                        </div>
                        {{-- step2 --}}
                        <div class="mt-4 rounded shadow p-4 bg-white flex flex-col">
                            <div class="font-bold text-gray-800">Step 2/4</div>
                            <div class="mt-4 font-light text-gray-800">
                                Click "template file" and open "theme.liquid" file
                            </div>
                            <div class="mt-2">
                                <img src="{{ asset('image/fsb_step2_1.png') }}" alt="">
                            </div>
                            <div class="mt-2">
                                <img src="{{ asset('image/fsb_step2_2.png') }}" alt="">
                            </div>
                        </div>
                        {{-- step3 --}}
                        <div class="mt-4 rounded shadow p-4 bg-white flex flex-col">
                            <div class="font-bold text-gray-800">Step 3/4</div>
                            <div class="mt-4 font-light text-gray-800">
                                Copy the following code:
                            </div>
                            <div class="mt-4 flex">
                                <div id="fsb" class="flex-1 border border-gray-300 rounded-sm px-4 py-2 text-gray-800 text-sm"></div>
                                <div id="copy-fsb" class="ml-1 rounded-sm text-white bg-green-700 px-5 py-2 cursor-pointer hover:bg-green-600">Copy</div>
                            </div>
                            <div class="mt-4 font-light text-gray-800">
                                Paste the code inside where you want display the bar.
                            </div>
                            <div class="mt-2">
                                <img src="{{ asset('image/fsb_step3.png') }}" alt="">
                            </div>
                            <div class="mt-4 font-light text-gray-800">
                                For sticky bar you can copy the following code:
                            </div>
                            <div class="mt-4 flex">
                                <div id="fsb-sticky" class="flex-1 border border-gray-300 rounded-sm px-4 py-2 text-gray-800 text-sm"></div>
                                <div id="copy-fsb-sticky" class="ml-1 rounded-sm text-white bg-green-700 px-5 py-2 cursor-pointer hover:bg-green-600">Copy</div>
                            </div>
                            <div class="mt-4 font-light text-gray-800">
                                Paste the code inside where you want display the bar.
                            </div>
                            <div class="mt-2">
                                <img src="{{ asset('image/fsb_step3_2.png') }}" alt="">
                            </div>
                        </div>

                        {{-- step5 --}}
                        <div class="mt-4 rounded shadow p-4 bg-white flex flex-col">
                            <div class="font-bold text-gray-800">Step 4/4</div>
                            <div class="mt-4 font-light text-gray-800">
                                Click "Save"
                            </div>
                            <div class="mt-4">
                                <img src="{{ asset('image/fsb_step4.png') }}" alt="">
                            </div>
                        </div>

                        {{-- all set --}}
                        <div class="mt-4 rounded shadow p-4 bg-white flex flex-col">
                            <div class="font-bold text-gray-800">All Set 🎉</div>


                            <div class="mt-4 flex items-center">
                                <div class="text-blue-800">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M14.243 5.757a6 6 0 10-.986 9.284 1 1 0 111.087 1.678A8 8 0 1118 10a3 3 0 01-4.8 2.401A4 4 0 1114 10a1 1 0 102 0c0-1.537-.586-3.07-1.757-4.243zM12 10a2 2 0 10-4 0 2 2 0 004 0z" clip-rule="evenodd"></path></svg>
                                </div>
                                <div class="ml-1">
                                    <a class="text-blue-800" href="mailto:pengbo37877@gmail.com?subject=[Currency Converter Ant] guide help" target="_blank">Contact Support</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="span-col-1"></div>
            </div>
        </div>
        <script>

            var fsb = document.getElementById('fsb');
            fsb.innerHTML = '&lt;div class=&quot;pdd-cb-bars&quot;&gt;&lt;/div&gt;';
            var fsbSticky = document.getElementById('fsb-sticky');
            fsbSticky.innerHTML = '&lt;div class=&quot;pdd-cb-sticky-bars&quot;&gt;&lt;/div&gt;';

            var copyFsb = document.getElementById('copy-fsb');
            var copyFsbSticky = document.getElementById('copy-fsb-sticky');

            copyFsb.addEventListener('click', function() {
                var textArea = document.createElement("textarea");
                textArea.value = '<div class="pdd-cb-bars"></div>';

                // Avoid scrolling to bottom
                textArea.style.top = "0";
                textArea.style.left = "0";
                textArea.style.position = "fixed";

                document.body.appendChild(textArea);
                textArea.focus();
                textArea.select();
                textArea.setSelectionRange(0, 99999);

                try {
                    var successful = document.execCommand('copy');
                    var msg = successful ? 'successful' : 'unsuccessful';
                    console.log('Fallback: Copying text command was ' + msg);
                } catch (err) {
                    console.error('Fallback: Oops, unable to copy', err);
                }
                document.body.removeChild(textArea);
                alert("Copied to Clipboard!");
            });

            copyFsbSticky.addEventListener('click', function() {
                var textArea = document.createElement("textarea");
                textArea.value = '<div class="pdd-cb-sticky-bars"></div>';

                // Avoid scrolling to bottom
                textArea.style.top = "0";
                textArea.style.left = "0";
                textArea.style.position = "fixed";

                document.body.appendChild(textArea);
                textArea.focus();
                textArea.select();
                textArea.setSelectionRange(0, 99999);

                try {
                    var successful = document.execCommand('copy');
                    var msg = successful ? 'successful' : 'unsuccessful';
                    console.log('Fallback: Copying text command was ' + msg);
                } catch (err) {
                    console.error('Fallback: Oops, unable to copy', err);
                }
                document.body.removeChild(textArea);
                alert("Copied to Clipboard!");
            })
        </script>
    </body>
</html>
