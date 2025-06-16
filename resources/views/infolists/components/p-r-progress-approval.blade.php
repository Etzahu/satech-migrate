<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    <div>
        @dump($getState())
        {{-- {{ $getState() }} --}}
    </div>
</x-dynamic-component>


