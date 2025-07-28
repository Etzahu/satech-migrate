<div class="flex flex-col items-center justify-center">
    <div class="grid grid-cols-6 gap-1">
        @foreach ($menu as $itemMenu)
            <a href="{{ $itemMenu['link'] }}">
                <div
                    class="flex flex-col items-center justify-center w-48 p-2 m-2 duration-300 bg-gray-100 border border-gray-300 shadow h-44 rounded-xl hover:bg-white hover:shadow-xl">
                    <span class="font-bold leading-5 text-center">{{ $itemMenu['area'] }}</span>
                </div>
            </a>
        @endforeach
    </div>
    <!-- component -->
</div>
