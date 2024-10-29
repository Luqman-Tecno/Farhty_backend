<x-guest-layout>
    <div class="min-h-screen bg-gray-100 px-4" dir="rtl">
        <div class="flex min-h-screen items-center justify-center">
            <div class="w-full max-w-[400px] animate-fadeIn"> <!-- Reduced max-width -->
                <div class="relative rounded-[25px] bg-white px-6 py-8 shadow-2xl shadow-gray-200/60 backdrop-blur-sm"> <!-- Reduced padding -->
                    <div class="absolute -right-4 -top-4 h-20 w-20 rounded-2xl bg-gradient-to-br from-indigo-500 to-indigo-600 p-3 shadow-lg"> <!-- Reduced size and position -->
                        <x-authentication-card-logo class="h-full w-full text-white" />
                    </div>

                    <h2 class="mb-6 mt-9 text-right text-2xl font-bold text-gray-800">إنشاء حساب جديد</h2> <!-- Reduced text size and margins -->

                    <x-validation-errors class="mb-4 rounded-xl bg-red-50 p-3 text-sm text-red-600" />

                    <form method="POST" action="{{ route('register') }}" class="space-y-4"> <!-- Reduced spacing -->
                        @csrf

                        <div class="space-y-1"> <!-- Reduced spacing -->
                            <x-label for="name" value="{{ __('الاسم') }}" class="block text-sm font-medium text-gray-600" />
                            <div class="group relative">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <x-input id="name"
                                         class="block w-full rounded-xl border-2 border-gray-100 bg-gray-50 px-3 py-2 pr-10 text-sm placeholder-gray-400 transition-all duration-200 focus:border-indigo-400 focus:bg-white focus:outline-none focus:ring focus:ring-indigo-100"
                                         type="text"
                                         name="name"
                                         :value="old('name')"
                                         placeholder="أدخل اسمك"
                                         required
                                         autofocus
                                         autocomplete="name" />
                            </div>
                        </div>

                        <div class="space-y-1">
                            <x-label for="email" value="{{ __('البريد الإلكتروني') }}" class="block text-sm font-medium text-gray-600" />
                            <div class="group relative">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                    </svg>
                                </div>
                                <x-input id="email"
                                         class="block w-full rounded-xl border-2 border-gray-100 bg-gray-50 px-3 py-2 pr-10 text-sm placeholder-gray-400 transition-all duration-200 focus:border-indigo-400 focus:bg-white focus:outline-none focus:ring focus:ring-indigo-100"
                                         type="email"
                                         name="email"
                                         :value="old('email')"
                                         placeholder="name@example.com"
                                         required
                                         autocomplete="username" />
                            </div>
                        </div>

                        <div class="space-y-1">
                            <x-label for="password" value="{{ __('كلمة المرور') }}" class="block text-sm font-medium text-gray-600" />
                            <div class="group relative">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <x-input id="password"
                                         class="block w-full rounded-xl border-2 border-gray-100 bg-gray-50 px-3 py-2 pr-10 text-sm placeholder-gray-400 transition-all duration-200 focus:border-indigo-400 focus:bg-white focus:outline-none focus:ring focus:ring-indigo-100"
                                         type="password"
                                         name="password"
                                         placeholder="أدخل كلمة المرور"
                                         required
                                         autocomplete="new-password" />
                            </div>
                        </div>

                        <div class="space-y-1">
                            <x-label for="password_confirmation" value="{{ __('تأكيد كلمة المرور') }}" class="block text-sm font-medium text-gray-600" />
                            <div class="group relative">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <x-input id="password_confirmation"
                                         class="block w-full rounded-xl border-2 border-gray-100 bg-gray-50 px-3 py-2 pr-10 text-sm placeholder-gray-400 transition-all duration-200 focus:border-indigo-400 focus:bg-white focus:outline-none focus:ring focus:ring-indigo-100"
                                         type="password"
                                         name="password_confirmation"
                                         placeholder="أعد إدخال كلمة المرور"
                                         required
                                         autocomplete="new-password" />
                            </div>
                        </div>

                        @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                            <div class="space-y-1">
                                <x-label for="terms">
                                    <div class="flex items-center">
                                        <x-checkbox name="terms" id="terms" required class="h-4 w-4 rounded border-gray-300 text-indigo-500 transition focus:ring-2 focus:ring-indigo-500" />
                                        <div class="mr-2 text-xs text-gray-600">
                                            {!! __('أوافق على :terms_of_service و :privacy_policy', [
                                                'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="font-medium text-indigo-500 transition-colors hover:text-indigo-600">'.__('شروط الخدمة').'</a>',
                                                'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="font-medium text-indigo-500 transition-colors hover:text-indigo-600">'.__('سياسة الخصوصية').'</a>',
                                            ]) !!}
                                        </div>
                                    </div>
                                </x-label>
                            </div>
                        @endif

                        <div>
                            <x-button class="relative flex w-full items-center justify-center overflow-hidden rounded-xl bg-indigo-500 px-4 py-2.5 text-sm font-semibold text-white transition-all duration-300 hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2 active:scale-[0.98]">
                                <span class="relative z-10">{{ __('إنشاء حساب') }}</span>
                            </x-button>
                        </div>

                        <p class="mt-3 text-center text-xs text-gray-600">
                            لديك حساب بالفعل؟
                            <a href="{{ route('login') }}" class="font-medium text-indigo-500 transition-colors hover:text-indigo-600">
                                تسجيل الدخول
                            </a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
