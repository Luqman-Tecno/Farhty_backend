<div class=" relative overflow-hidden" dir="rtl">
    <!-- Hero Section with Background -->
    <div class="relative min-h-[80vh] bg-gradient-to-br from-purple-900 via-gray-800 to-gray-900">
        <!-- Decorative Elements -->
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-0 left-0 w-72 h-72 bg-purple-500 rounded-full filter blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-72 h-72 bg-indigo-500 rounded-full filter blur-3xl"></div>
        </div>

        <!-- Main Content -->
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="space-y-12">
                <!-- Main Heading -->
                <div class="max-w-4xl">
                    <h1 class="text-5xl md:text-6xl font-bold text-white mb-6 leading-tight">
                        حول حلمك إلى <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-400">حقيقة</span>
                    </h1>

                    <!-- Description Box -->
                    <div class="backdrop-blur-md bg-white/10 rounded-2xl p-6 border border-white/20 shadow-xl">
                        <p class="text-xl text-gray-200 leading-relaxed">
                            نحول مناسباتكم إلى لحظات لا تُنسى. سهولة الحجز عبر موقعنا تضمن لكم تجربة سلسة وممتعة.
                            ابدأ الآن واختر الصالة المثالية ليومك المميز!
                        </p>
                    </div>
                </div>

                <!-- Call to Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-6">
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
    </div>

    <!-- Popular Cities Section -->
    <div class="bg-gray-50 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-600">
                        الــمــــدن الـرائــجـــة
                    </span>
                </h2>
                <div class="w-24 h-1 bg-gradient-to-r from-purple-600 to-pink-600 mx-auto rounded-full"></div>
            </div>

            <!-- Cities Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($city->take(4) as $cites)
                    <a href="#" class="group">
                        <article class="relative h-96 rounded-2xl overflow-hidden shadow-lg transition-all duration-300 transform group-hover:scale-[1.02]">
                            <!-- Image -->
                            <img src="https://images.unsplash.com/photo-1499856871958-5b9627545d1a"
                                 alt="{{$cites->name_ar}}"
                                 class="absolute inset-0 h-full w-full object-cover transition-transform duration-700 group-hover:scale-110">

                            <!-- Gradient Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-purple-900/90 via-purple-900/40 to-transparent opacity-90 group-hover:opacity-100 transition-opacity duration-300"></div>

                            <!-- Content -->
                            <div class="absolute bottom-0 p-6 w-full">
                                <div class="transform transition-transform duration-300 group-hover:translate-y-[-8px]">
                                    <h3 class="text-3xl font-bold text-white mb-2">{{$cites->name_ar}}</h3>
                                    <p class="text-purple-200 opacity-90">اكتشف الأماكن المميزة</p>

                                    <!-- Hidden details that appear on hover -->
                                    <div class="flex items-center gap-2 mt-4 opacity-0 transform translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300">
                                        <span class="text-white">استكشف المزيد</span>
                                        <svg class="w-5 h-5 text-white rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
