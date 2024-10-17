<nav class="bg-amber-600 text-white p-4 fixed top-0 left-0 right-0 z-50">
    <div class="container mx-auto flex justify-between items-center">
        <div class="text-xl font-bold">{{ config('app.name') }}</div>
        <ul class="flex space-x-4">
            <li><a href="{{ filament()->getHomeUrl() }}" class="hover:text-amber-200">الصفحة الرئيسية</a></li>
            <li><a href="#" class="hover:text-amber-200">العروض</a></li>
            <li><a href="#" class="hover:text-amber-200">عروض التخفيض</a></li>
            <!-- Add more menu items as needed -->
        </ul>
    </div>
</nav>
