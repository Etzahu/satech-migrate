<div class="flex flex-col items-center justify-center">
    <div class="grid grid-cols-6 gap-1">
        @foreach ($menu as $itemMenu)
            <a href="{{ $itemMenu['link'] }}">
                <div
                    class="flex flex-col items-center justify-center w-48 p-2 m-2 duration-300 bg-gray-100 border border-gray-300 shadow h-44 rounded-xl hover:bg-white hover:shadow-xl">
                    <span class="text-sm font-bold leading-5 text-center">{{ $itemMenu['area'] }}</span>
                    <p class="px-2 text-sm text-center text-gray-600">{{ $itemMenu['modulo'] }}</p>
                </div>
            </a>
        @endforeach
    </div>
    <!-- component -->
</div>
