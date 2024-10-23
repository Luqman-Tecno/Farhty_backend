<!-- resources/views/livewire/search-filters.blade.php -->
<div class="max-w-4xl mx-auto">
    <div class="bg-white/20 backdrop-blur-md rounded-xl p-6">
        <form wire:submit.prevent="search">
            {{ $this->form }}

            <!-- Search Button -->
            <div class="mt-6 flex justify-center">
                <button type="submit"
                        class="bg-purple-600 text-white px-6 py-2 rounded-full hover:bg-purple-700 transition-colors duration-300 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    بحث
                </button>
            </div>
        </form>
    </div>
</div>
