<x-layout>
    {{-- resources/views/livewire/wedding-hall-search.blade.php --}}
    <div class="container mx-auto p-4" dir="rtl">
        <div class="bg-white rounded-lg shadow-lg">
            {{-- Search Filters --}}
            <div class="flex flex-wrap gap-4 p-4 border-b">
                <div class="relative">
                    <select wire:model="cityId" class="rounded-lg border-gray-300 px-4 py-2 bg-purple-100 text-purple-800">
                        <option value="">كل المدن</option>
                        @dump($cities)
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="relative">
                    <input wire:model.debounce.300ms="region"
                           type="text"
                           class="rounded-lg border-gray-300 px-4 py-2 bg-purple-100 text-purple-800"
                           placeholder="ادخل المنطقة">
                </div>

                <div class="relative">
                    <select wire:model="capacity" class="rounded-lg border-gray-300 px-4 py-2 bg-purple-100 text-purple-800">
                        <option value="">عدد الكراسي</option>
                        @foreach([100, 150, 200, 250, 300, 400] as $cap)
                            <option value="{{ $cap }}">{{ $cap }} كرسي</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Sort Options --}}
            <div class="flex gap-4 p-4">
                <button wire:click="sortByPrice" class="flex items-center px-4 py-2 bg-purple-800 text-white rounded-lg">
                    فرز حسب السعر
                    @if($sortField === 'shift_prices')
                        <span class="mr-2">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                    @endif
                </button>
                <button wire:click="sortByCapacity" class="flex items-center px-4 py-2 bg-purple-800 text-white rounded-lg">
                    فرز حسب السعة
                    @if($sortField === 'capacity')
                        <span class="mr-2">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                    @endif
                </button>
            </div>

            {{-- Wedding Halls Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-4">
                @forelse($halls as $hall)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="relative">
                            @if($hall->images)
                                <img src="{{ asset(json_decode($hall->images)[0] ?? 'images/default-hall.jpg') }}"
                                     class="w-full h-48 object-cover"
                                     alt="{{ $hall->hall_name }}">
                            @else
                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-400">لا توجد صورة</span>
                                </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="text-xl font-bold text-right">{{ $hall->hall_name }}</h3>
                            <div class="flex justify-between items-center mt-4">
                                <div class="text-gray-600">
                                    <span>{{ $hall->capacity }} كرسي</span>
                                </div>
                                <div class="text-purple-800 font-bold">
                                    @if($hall->shift_prices)
                                        {{ number_format(json_decode($hall->shift_prices)->evening ?? 0, 2) }} د.ك
                                    @else
                                        السعر غير متوفر
                                    @endif
                                </div>
                            </div>
                            <div class="mt-2 text-gray-600">
                                <span>{{ $hall->city->name ?? '' }} - {{ $hall->region }}</span>
                            </div>
                            <div class="mt-2 text-sm text-gray-500">
                                <span>عربون: {{ $hall->deposit_price ?? 0 }} د.ك</span>
                            </div>
                            <button class="w-full mt-4 bg-purple-800 text-white py-2 px-4 rounded-lg hover:bg-purple-700 transition">
                                عرض التفاصيل
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-8 text-gray-500">
                        لم يتم العثور على قاعات تطابق معايير البحث
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-layout>
