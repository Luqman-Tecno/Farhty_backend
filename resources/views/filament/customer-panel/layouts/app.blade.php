@extends('filament::layouts.base')

@section('content')
    <div class="filament-app-layout flex h-full w-full flex-col">
        <!-- Custom top bar -->
        <nav class="bg-amber-600 text-white p-4">
            <div class="container mx-auto flex justify-between items-center">
                <div class="text-xl font-bold">{{ config('app.name') }}</div>
                <ul class="flex space-x-4">
                    <li><a href="{{ route('filament.customerPanel.pages.dashboard') }}" class="hover:text-amber-200">الصفحة الرئيسية</a></li>
                    <li><a href="#" class="hover:text-amber-200">العروض</a></li>
                    <li><a href="#" class="hover:text-amber-200">عروض التخفيض</a></li>
                    <!-- Add more menu items as needed -->
                </ul>
            </div>
        </nav>

        <!-- Main content -->
        <div class="filament-main flex-1 w-full px-4 mx-auto md:px-6 lg:px-8">
            {{ $slot }}
        </div>
    </div>
@endsection
