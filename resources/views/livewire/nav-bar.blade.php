<nav class="flex gap-7 items-center fixed top-0 z-20 w-full h-24 bg-gray-100 shadow-md rounded" dir="rtl">
    <ul class="flex text-purple-900 gap-12 items-center justify-center list-none w-[calc(50%-130px)]">
        <li class="transition-all duration-1000">
            <a href="{{ route('home') }}" class="font-bold text-xl cursor-pointer flex items-center  hover:border-b-2 hover:border-purple-900 {{ request()->routeIs('home') ? 'border-b-2 border-purple-600' : '' }}">
                الصفحة الرئيسية
            </a>
        </li>
        <li class="transition-all duration-1000">
            <a href="{{ route('offers') }}" class="font-bold text-xl cursor-pointer flex items-center hover:border-b-2 hover:border-purple-900 {{ request()->routeIs('offers') ? 'border-b-2 border-purple-600' : '' }}">
                العروض
            </a>
        </li>
        <li class="transition-all duration-1000">
            <a  class="font-bold text-xl cursor-pointer flex items-center hover:border-b-2 hover:border-purple-900  {{ request()->routeIs('ponude-popusta') ? 'border-b-2 border-purple-600' : '' }}">
                عروض التخفيض
            </a>
        </li>
    </ul>

    <div class="mx-auto flex flex-col items-center text-purple-900 w-50 relative -bottom-7   rounded-b-3xl bg-gray-100 py-4 px-4 ">
        <span class="text-4xl font-normal ">فرحتي</span>
        <span class="text-4xl font-semibold py-2">Farhty</span>
    </div>

    <ul class="flex  text-purple-900 gap-12 items-center justify-center list-none w-[calc(50%-130px)]">
        <li class="transition-all duration-1000">
            <a href="{{ route('about') }}" class="font-bold text-xl cursor-pointer flex items-center {{ request()->routeIs('about') ? 'border-b-2 border-purple-600' : '' }}">
                حول الموقع
            </a>
        </li>
        <li class="transition-all duration-1000">
            <a href="{{ route('orders') }}" class="font-normal text-lg cursor-pointer flex items-center gap-2 custom-gradient rounded-full text-white px-4 py-1 w-36 {{ request()->routeIs('orders') ? 'border-b-2 border-purple-600' : '' }}">
                <i class="fas fa-shopping-cart w-8 h-8 text-base text-center bg-white text-purple-600 rounded-full flex items-center justify-center"></i>
                <span class="w-[calc(100%-34px)]">الـطـلبـات</span>
            </a>
        </li>
        <li class="transition-all duration-1000">
            <a href="{{ route('profile') }}" class="font-bold text-xl cursor-pointer flex items-center">
                <i class="far fa-user w-10 h-10 bg-blue-500 text-2xl text-center text-white rounded-full flex items-center justify-center"></i>
            </a>
        </li>
    </ul>
</nav>

