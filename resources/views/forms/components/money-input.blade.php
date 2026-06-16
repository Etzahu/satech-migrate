<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <x-filament::input.wrapper :valid="!$errors->has($getStatePath())">
        <input x-data="{ state: $wire.$entangle('{{ $getStatePath() }}') }" x-model="state" type="text" inputmode="decimal" id="{{ $getId() }}"
            class="block w-full fi-input" />
    </x-filament::input.wrapper>
</x-dynamic-component>
