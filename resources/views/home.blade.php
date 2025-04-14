<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <title>HOME</title>
    @vite('resources/css/home.css')
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body>
    <div class="flex items-center justify-center w-full min-h-screen bg-gray-50 ">
        <div class="relative w-full pb-6 border border-gray-600 md:w-11/12 lg:w-8/12 bg-whie rounded-xl">
            <h4 class="m-4 font-semibold text-left text-black">Menu</h4>
            <div class="flex flex-wrap items-center justify-center gap-4 mt-8 ">
                @foreach ($items as $item)
                    <div
                        class="w-[20rem] flex flex-col bg-gray-50  border  rounded-xl pb-4 hover:before:bg-redborder-red-500 relative  overflow-hidden  border-red-500  px-3 text-red-500 shadow-2xl transition-all before:absolute before:bottom-0 before:left-0 before:top-0 before:z-0 before:h-full before:w-0 before:bg-red-500 before:transition-all before:duration-500 hover:text-white hover:shadow-red-500 hover:before:left-0 hover:before:w-full">
                        <div class="mt-10 pl-4 w-[88%] flex flex-col">
                            <h4 class="text-[14px] font-semibold relative z-10 capitalize">
                                {{ $item['title'] }}
                            </h4>
                            <hr class="border-[1.5px] w-12 mt-6 mb-2  border-red-500  rounded relative z-10" />
                            <p class="text-[13px]  relative z-10 ">Ver</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</body>

</html>
