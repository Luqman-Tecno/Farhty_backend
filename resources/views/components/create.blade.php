{{-- resources/views/bookings/create.blade.php --}}
<x-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-bold mb-6">حجز قاعة {{ $weddingHall->name }}</h2>
                    @livewire('booking-form', ['weddingHall' => $weddingHall])
                </div>
            </div>
        </div>
    </div>
</x-layout>
