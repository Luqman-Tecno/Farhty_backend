<div class="relative overflow-hidden" dir="rtl">
    <!-- Hero Section -->
    <div class="relative min-h-screen bg-gradient-to-br from-purple-900 via-gray-800 to-gray-900">
        <!-- Decorative Elements -->
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-0 left-0 w-72 h-72 bg-purple-500 rounded-full filter blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-72 h-72 bg-indigo-500 rounded-full filter blur-3xl"></div>
        </div>

        <!-- Updated Main Content -->
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32">
            <div class="space-y-12">
                <div class="max-w-4xl animate-fade-in">
                    <h1 class="text-6xl md:text-7xl font-bold text-white mb-8 leading-tight animate-slide-up">
                        اكتشف <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-400">أفضل القاعات</span>
                        <br>لمناسبتك الخاصة
                    </h1>

                    <!-- Enhanced Description Box -->
                    <div class="backdrop-blur-xl bg-white/10 rounded-3xl p-8 border border-white/20 shadow-2xl transform hover:scale-[1.02] transition-all duration-300">
                        <p class="text-2xl text-gray-200 leading-relaxed">
                            نقدم لك تجربة فريدة لاختيار وحجز قاعات الأفراح والمناسبات
                            <br>
                            <span class="text-purple-300">أكثر من ١٠٠٠+ قاعة في مختلف المدن</span>
                        </p>
                    </div>
                </div>

                <!-- Enhanced CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-6 animate-fade-in-up">
                    <button class="group relative px-8 py-4 text-xl font-bold text-white bg-gradient-to-r from-purple-600 to-pink-600 rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                        <span class="relative z-10">احـجــز فرحـــك الآن</span>
                        <div class="absolute inset-0 bg-gradient-to-r from-purple-700 to-pink-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </button>

                    <button class="group relative px-8 py-4 text-xl font-bold text-white bg-transparent border-2 border-white/30 rounded-xl overflow-hidden hover:border-white/60 transition-all duration-300 backdrop-blur-sm">
                        <span class="flex items-center gap-3">
                            ابداء الان
                            <svg class="w-5 h-5 rtl:rotate-180 group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Added Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
            </svg>
        </div>
    </div>

    <!-- Enhanced Cities Section -->
    <div class="bg-gradient-to-b from-gray-900 to-gray-800 py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Updated Section Header -->
            <div class="text-center mb-16">
                <h2 class="text-5xl font-bold text-white mb-6">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-400">
                        أشهر المدن
                    </span>
                </h2>
                <p class="text-gray-300 text-xl">اختر مدينتك واكتشف أفضل القاعات المتاحة</p>
            </div>

            <!-- Enhanced Cities Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($cities as $city)
                    <div wire:click="redirectToOffers({{ $city->id }})" class="cursor-pointer">
                        <article class="relative h-[400px] rounded-3xl overflow-hidden shadow-2xl transition-all duration-500 transform hover:scale-[1.03] hover:shadow-purple-500/20">
                            <img src="{{ $city->image_url ?? 'https://images.unsplash.com/photo-1499856871958-5b9627545d1a' }}"
                                 alt="{{ $city->name_ar }}"
                                 class="absolute inset-0 h-full w-full object-cover transition-transform duration-700 hover:scale-110">

                            <!-- Enhanced Gradient Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-purple-900 via-purple-900/60 to-transparent opacity-90 hover:opacity-100 transition-opacity duration-300"></div>

                            <!-- Enhanced Content -->
                            <div class="absolute bottom-0 p-8 w-full">
                                <div class="transform transition-all duration-300 hover:translate-y-[-8px]">
                                    <h3 class="text-3xl font-bold text-white mb-3">{{ $city->name_ar }}</h3>
                                    <p class="text-purple-200 text-lg mb-4">
                                        {{ $city->wedding_halls_count }}
                                        {{ $city->wedding_halls_count == 1 ? 'قاعة متاحة' : 'قاعات متاحة' }}
                                    </p>
                                    
                                    <!-- Enhanced Call to Action -->
                                    <div class="flex items-center gap-3 text-white">
                                        <span class="text-lg">تصفح القاعات</span>
                                        <svg class="w-5 h-5 rtl:rotate-180 animate-bounce-x" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
