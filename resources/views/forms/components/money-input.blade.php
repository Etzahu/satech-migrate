<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div x-data="{ state: $wire.$entangle('{{ $getStatePath() }}') }">
         <input x-model="state" class="block w-full border-gray-300 rounded-lg shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm dark:bg-gray-800 dark:border-gray-700 focus:ring-2 focus:outline-none" />
    </div>
</x-dynamic-component>
