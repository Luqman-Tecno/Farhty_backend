<x-filament-panels::page>
    <form wire:submit.prevent="save">
        {{ $this->form }}

        <div class="mt-6">
            <x-filament::button type="submit" class="w-full">
                حفظ التغيرات
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
