<nav class="bg-gray-800">
  <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
    <div class="relative flex items-center justify-between h-16">
      <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">
        <div class="flex-shrink-0 flex items-center">
          <img class="block lg:hidden h-8 w-auto" src="{{ asset('image/fsb-logo.svg') }}" alt="FreeShipping">
          <img class="hidden lg:block h-8 w-auto" src="{{ asset('image/fsb-logo@2x.svg') }}" alt="FreeShipping">
        </div>
        <div class="hidden sm:block sm:ml-6">
          <div class="flex space-x-4">
            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
            <a href="/" class="@if(Request::path() == '/') bg-gray-900 text-white block px-3 py-2 rounded-md text-sm font-medium @else text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-sm font-medium @endif" aria-current="page">Dashboard</a>
            <a href="/fsb" class="@if(strpos(Request::path(), 'sb') == 1) bg-gray-900 text-white block px-3 py-2 rounded-md text-sm font-medium @else text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-sm font-medium @endif" aria-current="page">Free Shipping Notice Bars</a>
          </div>
        </div>
      </div>

    </div>
  </div>

  <!-- Mobile menu, show/hide based on menu state. -->
  <div class="sm:hidden" id="mobile-menu">
    <div class="px-2 pt-2 pb-3 space-y-1">
      <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
      <a href="/" class="@if(Request::path() == '/') bg-gray-900 text-white block px-3 py-2 rounded-md text-base font-medium @else text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium @endif" aria-current="page">Dashboard</a>
      <a href="/fsb" class="@if(strpos(Request::path(), 'sb') == 1) bg-gray-900 text-white block px-3 py-2 rounded-md text-base font-medium @else text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium @endif" aria-current="page">Free Shipping Notice Bars</a>
    </div>
  </div>
</nav>
