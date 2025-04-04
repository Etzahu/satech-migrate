<!doctype html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body>
    <nav class="bg-gray-200">
        <div class="px-2 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="relative flex items-center justify-between h-16">
                <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                    <!-- Mobile menu button-->
                    <button type="button"
                        class="relative inline-flex items-center justify-center p-2 text-gray-900 rounded-md hover:bg-gray-700 hover:text-white focus:ring-2 focus:ring-white focus:outline-hidden focus:ring-inset"
                        aria-controls="mobile-menu" aria-expanded="false">
                        <span class="absolute -inset-0.5"></span>
                        <span class="sr-only">Open main menu</span>
                        <!--
                  Icon when menu is closed.

                  Menu open: "hidden", Menu closed: "block"
                -->
                        <svg class="block size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" aria-hidden="true" data-slot="icon">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                        <!--
                  Icon when menu is open.

                  Menu open: "block", Menu closed: "hidden"
                -->
                        <svg class="hidden size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" aria-hidden="true" data-slot="icon">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="flex items-center justify-center flex-1 sm:items-stretch sm:justify-start">
                    <div class="flex items-center shrink-0">
                        <img class="w-auto h-8"
                            src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500"
                            alt="Your Company">
                    </div>
                    <div class="hidden sm:ml-6 sm:block">
                        <div class="flex space-x-4">
                            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                            <a href="#" class="px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-md"
                                aria-current="page">Dashboard</a>
                            <a href="#"
                                class="px-3 py-2 text-sm font-medium text-gray-900 rounded-md hover:bg-gray-700 hover:text-white">Team</a>
                            <a href="#"
                                class="px-3 py-2 text-sm font-medium text-gray-900 rounded-md hover:bg-gray-700 hover:text-white">Projects</a>
                            <a href="#"
                                class="px-3 py-2 text-sm font-medium text-gray-900 rounded-md hover:bg-gray-700 hover:text-white">Calendar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile menu, show/hide based on menu state. -->
        <div class="sm:hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                <a href="#" class="block px-3 py-2 text-base font-medium text-white bg-gray-900 rounded-md"
                    aria-current="page">Dashboard</a>
                <a href="#"
                    class="block px-3 py-2 text-base font-medium text-gray-900 rounded-md hover:bg-gray-700 hover:text-white">Team</a>
                <a href="#"
                    class="block px-3 py-2 text-base font-medium text-gray-900 rounded-md hover:bg-gray-700 hover:text-white">Projects</a>
                <a href="#"
                    class="block px-3 py-2 text-base font-medium text-gray-900 rounded-md hover:bg-gray-700 hover:text-white">Calendar</a>
            </div>
        </div>
    </nav>

</body>

</html>
