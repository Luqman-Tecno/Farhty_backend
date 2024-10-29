<x-guest-layout>
    <div class="min-h-screen bg-gray-100 px-4" dir="rtl">
        <div class="flex min-h-screen items-center justify-center">
            <div class="w-full max-w-[420px] animate-fadeIn">
                <div class="relative rounded-[30px] bg-white px-8 py-12 shadow-2xl shadow-gray-200/60 backdrop-blur-sm">
                    <div class="absolute -right-6 -top-6 h-24 w-24 rounded-2xl bg-gradient-to-br from-indigo-500 to-indigo-600 p-4 shadow-lg">
                        <x-authentication-card-logo class="h-full w-full text-white" />
                    </div>

                    <h2 class="mb-8 mt-6 text-right text-3xl font-bold text-gray-800">مرحباً بعودتك</h2>

                    <x-validation-errors class="mb-6 rounded-xl bg-red-50 p-4 text-red-600" />

                    @if (session('status'))
                        <div class="mb-6 rounded-xl bg-green-50 p-4 text-sm font-medium text-green-600">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <div class="space-y-2">
                            <x-label for="email" value="{{ __('البريد الإلكتروني') }}" class="block text-sm font-medium text-gray-600" />
                            <div class="group relative">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                    </svg>
                                </div>
                                <x-input id="email"
                                         class="block w-full rounded-xl border-2 border-gray-100 bg-gray-50 px-4 py-3 pr-12 placeholder-gray-400 transition-all duration-200 focus:border-indigo-400 focus:bg-white focus:outline-none focus:ring focus:ring-indigo-100"
                                         type="email"
                                         name="email"
                                         :value="old('email')"
                                         placeholder="name@example.com"
                                         required
                                         autofocus
                                         autocomplete="username" />
                            </div>
                        </div>

                        <div class="space-y-2">
                            <x-label for="password" value="{{ __('كلمة المرور') }}" class="block text-sm font-medium text-gray-600" />
                            <div class="group relative">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <x-input id="password"
                                         class="block w-full rounded-xl border-2 border-gray-100 bg-gray-50 px-4 py-3 pr-12 placeholder-gray-400 transition-all duration-200 focus:border-indigo-400 focus:bg-white focus:outline-none focus:ring focus:ring-indigo-100"
                                         type="password"
                                         name="password"
                                         placeholder="أدخل كلمة المرور"
                                         required
                                         autocomplete="current-password" />
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <label for="remember_me" class="flex cursor-pointer items-center">
                                <x-checkbox id="remember_me" name="remember" class="h-4 w-4 rounded border-gray-300 text-indigo-500 transition focus:ring-2 focus:ring-indigo-500" />
                                <span class="mr-2 select-none text-sm text-gray-600">{{ __('تذكرني') }}</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a class="text-sm font-medium text-indigo-500 transition-colors hover:text-indigo-600"
                                   href="{{ route('password.request') }}">
                                    {{ __('نسيت كلمة المرور؟') }}
                                </a>
                            @endif
                        </div>

                        <div>
                            <x-button class="relative flex  w-full items-center justify-center overflow-hidden rounded-xl bg-indigo-500 px-4 py-3.5 text-sm font-semibold text-white transition-all duration-300 hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2 active:scale-[0.98]">
                                <span class="relative z-10">{{ __('تسجيل الدخول') }}</span>
                            </x-button>
                        </div>

                        <p class="mt-4 text-center text-sm text-gray-600">
                            ليس لديك حساب؟
                            <a href="{{ route('register') }}" class="font-medium text-indigo-500 transition-colors hover:text-indigo-600">
                                إنشاء حساب جديد
                            </a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
