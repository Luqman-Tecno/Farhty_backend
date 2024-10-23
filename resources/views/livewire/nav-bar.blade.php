<nav class="flex gap-7 items-center  w-full h-24 bg-gray-100 shadow-md rounded" dir="rtl">
    <ul class="flex text-purple-900 gap-12 items-center justify-center list-none w-[calc(50%-130px)]">
        <li class="transition-all duration-1000">
            <a href="{{ route('home') }}"
               class="font-bold text-xl cursor-pointer flex items-center  hover:border-b-2 hover:border-purple-900 {{ request()->routeIs('home') ? 'border-b-2 border-purple-600' : '' }}">
                الصفحة الرئيسية
            </a>
        </li>
        <li class="transition-all duration-1000">
            <a href="{{ route('offers') }}"
               class="font-bold text-xl cursor-pointer flex items-center hover:border-b-2 hover:border-purple-900 {{ request()->routeIs('offers') ? 'border-b-2 border-purple-600' : '' }}">
                العروض
            </a>
        </li>
        <li class="transition-all duration-1000">
            <a class="font-bold text-xl cursor-pointer flex items-center hover:border-b-2 hover:border-purple-900  {{ request()->routeIs('ponude-popusta') ? 'border-b-2 border-purple-600' : '' }}">
                عروض التخفيض
            </a>
        </li>
    </ul>

    <div
        class="mx-auto flex flex-col items-center text-purple-900 w-50 relative -bottom-7   rounded-b-3xl bg-gray-100 py-4 px-4 ">
        <span class="text-4xl font-normal ">فرحتي</span>
        <span class="text-4xl font-semibold py-2">Farhty</span>
    </div>

    <ul class="flex  text-purple-900 gap-12 items-center justify-center list-none w-[calc(50%-130px)]">
        <li class="transition-all duration-1000">
            <a href="{{ route('about') }}"
               class="font-bold text-xl cursor-pointer flex items-center {{ request()->routeIs('about') ? 'border-b-2 border-purple-600' : '' }}">
                حول الموقع
            </a>
        </li>
        @if (Auth::check())
        <li class="transition-all duration-1000">
            <a href="{{ route('orders') }}"
               class="font-normal text-lg cursor-pointer flex items-center gap-2 custom-gradient rounded-full text-white px-4 py-1 w-36 {{ request()->routeIs('orders') ? 'border-b-2 border-purple-600' : '' }}">
                <i class="fas fa-shopping-cart w-8 h-8 text-base text-center bg-white text-purple-600 rounded-full flex items-center justify-center"></i>
                <span class="w-[calc(100%-34px)]">الـطـلبـات</span>
            </a>
        </li>
        @endif
        <li class="transition-all duration-1000">
            @if (!Auth::check())
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Register</a>
            @endif
        </li>
        @if (Auth::check())
            <li class="transition-all duration-1000">
                <!-- Settings Dropdown -->
                <div class="ms-3 relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button
                                    class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    <img class="h-8 w-8 rounded-full object-cover"
                                         src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}"/>
                                </button>
                            @else
                                <span class="inline-flex rounded-md">
                                    <button type="button"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                        {{ Auth::user()->name }}

                                        <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                             viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                                        </svg>
                                    </button>
                                </span>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Manage Account') }}
                            </div>

                            <x-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <x-dropdown-link href="{{ route('api-tokens.index') }}">
                                    {{ __('API Tokens') }}
                                </x-dropdown-link>
                            @endif

                            <div class="border-t border-gray-200"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf

                                <x-dropdown-link href="{{ route('logout') }}"
                                                 @click.prevent="$root.submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>


            </li>
        @endif
    </ul>
</nav>

