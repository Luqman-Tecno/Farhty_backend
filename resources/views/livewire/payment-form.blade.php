<div dir="rtl">
    <section class="bg-gray-50 py-8 antialiased md:py-12">
        <div class="mx-auto max-w-3xl px-4">
            <h2 class="text-2xl font-semibold text-gray-800">تفاصيل الدفع</h2>

            <!-- إضافة التحذير هنا -->
            <div class="mt-4 rounded-lg bg-red-50 p-4 text-red-800 border border-red-200">
                <div class="flex items-center">
                    <svg class="h-5 w-5 ml-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <p class="font-medium">تنبيه مهم</p>
                </div>
                <p class="mt-2 text-sm">يرجى العلم أنه لا يمكن استرداد مبلغ العربون بعد إتمام عملية الدفع. يرجى التأكد من جميع التفاصيل قبل المتابعة.</p>
            </div>

            @if (session()->has('message'))
                <div class="mb-4 mt-4 rounded-lg bg-green-100 p-4 text-green-700">
                    {{ session('message') }}
                </div>
            @endif

            @if (session()->has('error'))
                <div class="mb-4 mt-4 rounded-lg bg-red-100 p-4 text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            <form wire:submit.prevent="submitPayment" class="mt-6 space-y-6">
                <!-- ملخص الحجز -->
                <div class="overflow-hidden rounded-lg bg-white p-6 shadow-sm">
                    <h3 class="mb-4 text-lg font-medium text-gray-900">ملخص الحجز</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between border-b pb-3">
                            <span class="text-gray-600">رقم الحجز:</span>
                            <span class="font-medium text-gray-900">#{{ $booking->id }}</span>
                        </div>
                        <div class="flex justify-between border-b pb-3">
                            <span class="text-gray-600">تاريخ المناسبة:</span>
                            <span class="font-medium text-gray-900">
                                {{ Carbon\Carbon::parse($booking->booking_date)->locale('ar')->translatedFormat('l j F Y') }}
                            </span>
                        </div>
                        <div class="flex justify-between border-b pb-3">
                            <span class="text-gray-600">القاعة:</span>
                            <span class="font-medium text-gray-900">{{ $weddingHall->hall_name }}</span>
                        </div>
                        
                        <!-- تفاصيل التكلفة -->
                        <div class="rounded-md bg-gray-50 p-4">
                            <div class="flex justify-between pb-2">
                                <span class="text-gray-600">التكلفة الأساسية:</span>
                                <span class="font-medium text-gray-900">{{ number_format($booking->total_cost, 2) }} د.ل</span>
                            </div>
                            
                            @if($salePrice > 0)
                                <div class="flex justify-between border-t border-dashed border-gray-200 pt-2">
                                    <span class="text-green-600">خصم العرض:</span>
                                    <span class="font-medium text-green-600">
                                        {{ number_format( $salePrice, 2) }} د.ل
                                    </span>
                                </div>
                                <div class="flex justify-between border-t border-gray-200 pt-2 text-lg font-bold">
                                    <span class="text-gray-900">السعر النهائي:</span>
                                    <span class="text-gray-900">{{ number_format($finalAmount, 2) }} د.ل</span>
                                </div>
                            @endif

                            <div class="mt-3 border-t border-gray-200 pt-3">
                                <div class="flex justify-between text-gray-600">
                                    <span>العربون المطلوب :</span>
                                    <span class="font-medium text-gray-900">{{ number_format($depositRequired, 2) }} د.ل</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- تفاصيل الدفع -->
                <div class="rounded-lg bg-white p-6 shadow-sm">
                    <h3 class="mb-4 text-lg font-medium text-gray-900">طريقة الدفع</h3>
                    
                    <!-- المبلغ -->
                    <div class="mb-4">
                        <label class="mb-1 block text-sm font-medium text-gray-700">قيمة العربون</label>
                        <div class="relative">
                            <input 
                                wire:model="amount" 
                                type="number" 
                                step="0.01"
                                readonly 
                                class="block w-full rounded-md border-gray-300 pl-12 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-50"
                                value="{{ $depositRequired }}"
                            >
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">د.ل</span>
                        </div>
                        @error('amount') <span class="mt-1 text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <!-- طريقة الدفع -->
                    <div class="mb-4">
                        <label class="mb-1 block text-sm font-medium text-gray-700">اختر طريقة الدفع</label>
                        <select 
                            wire:model.live="paymentMethod" 
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        >
                            <option value="">اختر الطريقة</option>
                            <option value="credit_card">بطاقة ائتمان</option>
                            <option value="debit_card">بطاقة تداول</option>
                            <option value="paypal">PayPal</option>
                        </select>
                        @error('paymentMethod') <span class="mt-1 text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <!-- تفاصيل البطاقة -->
                    @if($paymentMethod == 'credit_card' || $paymentMethod == 'debit_card')
                        <div class="mt-4 space-y-4">
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700">اسم حامل البطاقة</label>
                                <input 
                                    wire:model="fullName" 
                                    type="text" 
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    placeholder="الاسم كما يظهر على البطاقة"
                                >
                                @error('fullName') <span class="mt-1 text-sm text-red-600">{{ $message }}</span> @enderror
                            </div>

                            <div class="grid gap-4 md:grid-cols-2">
                                <div>
                                    <label class="mb-1 block text-sm font-medium text-gray-700">رقم البطاقة</label>
                                    <input 
                                        wire:model="cardNumber" 
                                        type="text" 
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                        placeholder="**** **** **** ****"
                                        maxlength="19"
                                    >
                                    @error('cardNumber') <span class="mt-1 text-sm text-red-600">{{ $message }}</span> @enderror
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="mb-1 block text-sm font-medium text-gray-700">تاريخ الانتهاء</label>
                                        <input 
                                            wire:model="cardExpiration" 
                                            type="text" 
                                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                            placeholder="MM/YY"
                                            maxlength="5"
                                        >
                                        @error('cardExpiration') <span class="mt-1 text-sm text-red-600">{{ $message }}</span> @enderror
                                    </div>

                                    <div>
                                        <label class="mb-1 block text-sm font-medium text-gray-700">رمز الأمان</label>
                                        <input 
                                            wire:model="cvv" 
                                            type="password" 
                                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                            placeholder="***"
                                            maxlength="3"
                                        >
                                        @error('cvv') <span class="mt-1 text-sm text-red-600">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- زر الدفع -->
                <div class="flex justify-end">
                    <button 
                        type="submit" 
                        class="inline-flex items-center rounded-md bg-blue-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed"
                        wire:loading.attr="disabled"
                    >
                        <span wire:loading.remove>إتمام الدفع</span>
                        <span wire:loading class="flex items-center">
                            <svg class="mr-3 -ml-1 h-5 w-5 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            جاري المعالجة...
                        </span>
                    </button>
                </div>
            </form>

            <!-- شعارات طرق الدفع -->
            <div class="mt-8 text-center">
                <p class="text-sm text-gray-500">معاملات آمنة ومشفرة بواسطة</p>
                <div class="mt-4 flex items-center justify-center space-x-4 space-x-reverse">
                    <img class="h-8 w-auto" src="{{ asset('images/visa.svg') }}" alt="Visa">
                    <img class="h-8 w-auto" src="{{ asset('images/mastercard.svg') }}" alt="Mastercard">
                    <img class="h-8 w-auto" src="{{ asset('images/paypal.svg') }}" alt="PayPal">
                </div>
            </div>
        </div>
    </section>
</div>

