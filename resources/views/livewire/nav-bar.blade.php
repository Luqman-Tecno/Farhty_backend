{{-- resources/views/livewire/nav-bar.blade.php --}}
<div class="sticky top-0 z-10">
    <nav class="bg-gray-100 shadow-md rounded" dir="rtl">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Mobile menu button -->
            <div class="flex justify-between items-center lg:hidden py-4">
                <button type="button" wire:click="toggleMobileMenu" class="text-purple-900">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <!-- Mobile Logo -->
                <div class="text-center text-purple-900">
                    <div class="text-2xl font-normal">فرحتي</div>
                    <div class="text-2xl font-semibold">Farhty</div>
                </div>
                <!-- Mobile Cart Icon -->
                @if (Auth::check())
                    <a href="{{ route('orders') }}" class="text-purple-900">
                        <div class="relative">
                            <i class="fas fa-shopping-cart text-2xl"></i>
                            <span class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs">
                            {{ $cartCount }}
                        </span>
                        </div>
                    </a>
                @endif
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex lg:justify-between lg:h-24 lg:items-center">
                <!-- Right Menu Items -->
                <ul class="flex items-center space-x-8 space-x-reverse">
                    <li>
                        <a href="{{ route('home') }}"
                           class="font-bold text-xl text-purple-900 hover:text-purple-700 transition-colors duration-200 py-2 inline-block hover:border-b-2 hover:border-purple-900 {{ request()->routeIs('home') ? 'border-b-2 border-purple-600' : '' }}"
                           wire:navigate>
                            الصفحة الرئيسية
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('offers') }}"
                           class="font-bold text-xl text-purple-900 hover:text-purple-700 transition-colors duration-200 py-2 inline-block hover:border-b-2 hover:border-purple-900 {{ request()->routeIs('offers') ? 'border-b-2 border-purple-600' : '' }}"
                           wire:navigate>
                            العروض
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('offers/discount') }}" class="font-bold text-xl text-purple-900 hover:text-purple-700 transition-colors duration-200 py-2 inline-block hover:border-b-2 hover:border-purple-900 {{ request()->routeIs('ponude-popusta') ? 'border-b-2 border-purple-600' : '' }}">
                            عروض التخفيض
                        </a>
                    </li>
                </ul>

                <!-- Logo -->
                <div class="flex flex-col items-center text-purple-900 relative -bottom-7 rounded-b-3xl bg-gray-100 py-4 px-8">
                    <span class="text-4xl font-normal">فرحتي</span>
                    <span class="text-4xl font-semibold py-2">Farhty</span>
                </div>

                <!-- Left Menu Items -->
                <ul class="flex items-center space-x-8 space-x-reverse">
                    <li>
                        <a href="{{ route('about') }}"
                           class="font-bold text-xl text-purple-900 hover:text-purple-700 transition-colors duration-200 py-2 inline-block hover:border-b-2 hover:border-purple-900 {{ request()->routeIs('about') ? 'border-b-2 border-purple-600' : '' }}">
                            حول الموقع
                        </a>
                    </li>
                    @if (Auth::check())
                        <!-- Orders Button -->
                        <li>
                            <a href="{{ route('orders') }}"
                               class="flex items-center relative group gap-2 bg-gradient-to-r from-purple-600 to-purple-800 text-white px-4 py-2 rounded-full hover:opacity-90 transition-opacity">
                                <div class="p-2 bg-purple-600 rounded-full hover:bg-purple-700 transition-colors">
                                    <i class="fas fa-shopping-cart text-white text-xl"></i>
                                    <span class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs">
                                        {{ $cartCount }}
                                    </span>
                                </div>
                                <span>الـطـلبـات</span>
                            </a>
                        </li>
                    @endif
                    @if (!Auth::check())
                        <li class="flex items-center space-x-4 space-x-reverse">
                            <a href="{{ route('login') }}"
                               class="bg-purple-600 text-white px-6 py-2 rounded-full hover:bg-purple-700 transition-colors duration-200">
                                تسجيل الدخول
                            </a>
                            <a href="{{ route('register') }}"
                               class="border-2 border-purple-600 text-purple-600 px-6 py-2 rounded-full hover:bg-purple-600 hover:text-white transition-colors duration-200">
                                التسجيل
                            </a>
                        </li>
                    @endif
                    @if (Auth::check())
                        <li>
                            <div class="ms-3 relative">
                                <x-dropdown align="right" width="48">
                                    <x-slot name="trigger">
                                        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                            <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                                <img class="h-8 w-8 rounded-full object-cover"
                                                     src="{{ Auth::user()->profile_photo_url }}"
                                                     alt="{{ Auth::user()->name }}"/>
                                            </button>
                                        @else
                                            <span class="inline-flex rounded-md">
                                                <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                                    {{ Auth::user()->name }}
                                                    <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                                                    </svg>
                                                </button>
                                            </span>
                                        @endif
                                    </x-slot>

                                    <x-slot name="content">
                                        <!-- Account Management -->
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            {{ 'ادارة الحساب' }}
                                        </div>

                                        <x-dropdown-link href="{{ route('profile.show') }}">
                                            {{ 'الملف الشحصي' }}
                                        </x-dropdown-link>

                                        @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                            <x-dropdown-link href="{{ route('api-tokens.index') }}">
                                                {{ __('API Tokens') }}
                                            </x-dropdown-link>
                                        @endif

                                        <div class="border-t border-gray-200"></div>

                                        <!-- Authentication -->
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <x-dropdown-link href="{{ route('logout') }}"
                                                             onclick="event.preventDefault(); this.closest('form').submit();">
                                                {{ 'تسجيل الخروج' }}
                                            </x-dropdown-link>
                                        </form>
                                    </x-slot>
                                </x-dropdown>
                            </div>
                        </li>
                    @endif
                </ul>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen"
             class="lg:hidden bg-white border-t"
             wire:transition>
            <div class="px-4 pt-2 pb-3 space-y-1">
                <a href="{{ route('home') }}" class="block px-3 py-2 text-base font-medium text-purple-900 hover:bg-gray-50 hover:text-purple-700 rounded-md" wire:navigate>الصفحة الرئيسية</a>
                <a href="{{ route('offers') }}" class="block px-3 py-2 text-base font-medium text-purple-900 hover:bg-gray-50 hover:text-purple-700 rounded-md" wire:navigate>العروض</a>
                <a href="{{ route('offers/discount') }}" class="block px-3 py-2 text-base font-medium text-purple-900 hover:bg-gray-50 hover:text-purple-700 rounded-md">عروض التخفيض</a>
                <a href="{{ route('about') }}" class="block px-3 py-2 text-base font-medium text-purple-900 hover:bg-gray-50 hover:text-purple-700 rounded-md">حول الموقع</a>
                @if (Auth::check())
                    <a href="{{ route('orders') }}" class="block px-3 py-2 text-base font-medium text-purple-900 hover:bg-gray-50 hover:text-purple-700 rounded-md">سلة التسوق</a>
                    <a href="{{ route('orders') }}" class="block px-3 py-2 text-base font-medium text-purple-900 hover:bg-gray-50 hover:text-purple-700 rounded-md">الـطـلبـات</a>
                    <a href="{{ route('profile.show') }}" class="block px-3 py-2 text-base font-medium text-purple-900 hover:bg-gray-50 hover:text-purple-700 rounded-md">الملف الشخصي</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-right block px-3 py-2 text-base font-medium text-purple-900 hover:bg-gray-50 hover:text-purple-700 rounded-md">تسجيل الخروج</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block px-3 py-2 text-base font-medium bg-purple-600 text-white hover:bg-purple-700 rounded-md text-center mb-2">تسجيل الدخول</a>
                    <a href="{{ route('register') }}" class="block px-3 py-2 text-base font-medium border-2 border-purple-600 text-purple-600 hover:bg-purple-600 hover:text-white rounded-md text-center">التسجيل</a>
                @endif
            </div>
        </div>
    </nav>
</div>
