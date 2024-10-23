<div class="text-xs text-gray-600 flex flex-col w-full">
    <span class="font-semibold"> مرحبا, {{ auth()->user()->name }} </span>
    <span>{{ now()->toFormattedDateString() }}</span>
</div>
