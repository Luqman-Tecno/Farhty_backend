<x-layout>
    <!-- Hero Section -->
    <div class=" bg-gradient-to-b from-gray-800 to-gray-600 p-6">
        <div class="max-w-7xl mx-auto space-y-8">
            <!-- Book Now Button -->
            <div class="flex justify-start">
                <button
                    class="bg-purple-600 text-white px-8 py-4 rounded-tr-3xl rounded-bl-3xl hover:bg-purple-700 transition-colors duration-300 text-2xl font-bold">
                    احـجــز فرحـــك الآن
                </button>
            </div>

            <!-- Description -->
            <div class="max-w-3xl">
                <div
                    class="bg-gray-900/50 border-2 border-white/20 text-white p-6 rounded-tr-3xl rounded-bl-3xl backdrop-blur-sm">
                    <p class="text-lg leading-relaxed">
                        نحول مناسباتكم إلى لحظات لا تُنسى سهولة الحجز عبر موقعنا تضمن لكم تجربة سلسة و ممتعة ابدأ الآن و
                        اختــر الصالــة المثاليــة ليومك المميز!
                    </p>
                </div>
            </div>

            <!-- Start Now Button -->
            <div class="flex justify-start">
                <button
                    class="bg-purple-900 text-white px-8 py-4 rounded-full hover:bg-purple-800 transition-colors duration-300 text-xl font-bold flex items-center gap-2">
                    ابداء الان
                    <svg class="w-5 h-5 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </button>
            </div>


            <!-- Search Bar -->

            <!-- Popular Cities Section -->
            <div class="bg-white py-12">
                <div class="max-w-7xl mx-auto px-6">
                    <h2 class="text-purple-900 text-4xl font-bold mb-8">
                        الــمــــدن الـرائــجـــة
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <!-- City Card -->
                        <article class="relative group overflow-hidden rounded-2xl aspect-[4/5]">
                            <img src="https://images.unsplash.com/photo-1499856871958-5b9627545d1a"
                                 alt="Paris"
                                 class="absolute inset-0 h-full w-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900/90 via-gray-900/40"></div>
                            <div class="absolute bottom-0 p-6">
                                <h3 class="text-3xl font-bold text-white mb-2">Paris</h3>
                                <p class="text-gray-300">City of love</p>
                            </div>
                        </article>
                        <!-- Add more city cards as needed -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
