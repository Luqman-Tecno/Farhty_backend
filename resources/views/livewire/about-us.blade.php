<div class="bg-gray-100 min-h-screen py-12" dir="rtl">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- قسم حول الموقع -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-12">
            <h2 class="text-3xl font-bold text-purple-900 mb-6">انضم إلينا كمزود خدمة</h2>
            <div class="prose max-w-none text-gray-600">
                <p class="mb-4">هل تمتلك قاعة أفراح؟ انضم إلى منصتنا وابدأ في استقبال الحجوزات عبر الإنترنت.</p>
                <p class="mb-4 text-purple-700 font-semibold">ملاحظة: يتطلب إضافة قاعتك اشتراكاً شهرياً في منصتنا</p>
                <p class="mb-4">المميزات التي نقدمها:</p>
                <ul class="list-disc list-inside mb-4">
                    <li>إدارة سهلة للحجوزات</li>
                    <li>عرض قاعتك لآلاف العملاء المحتملين</li>
                    <li>نظام دفع آمن</li>
                    <li>دعم فني على مدار الساعة</li>
                    <li>تقارير وإحصائيات مفصلة</li>
                </ul>
            </div>
        </div>

        <!-- نموذج طلب إضافة قاعة -->
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h3 class="text-2xl font-bold text-purple-900 mb-6">نموذج طلب إضافة قاعة</h3>
            
            @if (session()->has('message'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
                    {{ session('message') }}
                </div>
            @endif

            <form wire:submit.prevent="sendRequest" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="owner_name" class="block text-gray-700 font-medium mb-2">اسم المالك</label>
                        <input type="text" wire:model="owner_name" id="owner_name" 
                               class="w-full px-4 py-2 border rounded-lg focus:ring-purple-500 focus:border-purple-500">
                        @error('owner_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="hall_name" class="block text-gray-700 font-medium mb-2">اسم القاعة</label>
                        <input type="text" wire:model="hall_name" id="hall_name" 
                               class="w-full px-4 py-2 border rounded-lg focus:ring-purple-500 focus:border-purple-500">
                        @error('hall_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-gray-700 font-medium mb-2">البريد الإلكتروني</label>
                        <input type="email" wire:model="email" id="email" 
                               class="w-full px-4 py-2 border rounded-lg focus:ring-purple-500 focus:border-purple-500">
                        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-gray-700 font-medium mb-2">رقم الهاتف</label>
                        <input type="tel" wire:model="phone" id="phone" 
                               class="w-full px-4 py-2 border rounded-lg focus:ring-purple-500 focus:border-purple-500">
                        @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="location" class="block text-gray-700 font-medium mb-2">موقع القاعة</label>
                        <input type="text" wire:model="location" id="location" 
                               class="w-full px-4 py-2 border rounded-lg focus:ring-purple-500 focus:border-purple-500">
                        @error('location') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="capacity" class="block text-gray-700 font-medium mb-2">السعة الاستيعابية</label>
                        <input type="number" wire:model="capacity" id="capacity" 
                               class="w-full px-4 py-2 border rounded-lg focus:ring-purple-500 focus:border-purple-500">
                        @error('capacity') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label for="services" class="block text-gray-700 font-medium mb-2">الخدمات المتوفرة</label>
                    <textarea wire:model="services" id="services" rows="3" 
                              placeholder="مثال: خدمة ضيافة، تنسيق زهور، إضاءة، صوتيات، الخ..."
                              class="w-full px-4 py-2 border rounded-lg focus:ring-purple-500 focus:border-purple-500"></textarea>
                    @error('services') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="description" class="block text-gray-700 font-medium mb-2">وصف تفصيلي للقاعة</label>
                    <textarea wire:model="description" id="description" rows="4" 
                              class="w-full px-4 py-2 border rounded-lg focus:ring-purple-500 focus:border-purple-500"></textarea>
                    @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <button type="submit" 
                        class="w-full bg-purple-600 text-white py-2 px-4 rounded-lg hover:bg-purple-700 transition duration-200">
                    إرسال الطلب
                </button>
            </form>
        </div>
    </div>
</div>
