<nav class="bg-white border-gray-200 dark:bg-gray-900">
    <div class="max-w-screen-2xl flex flex-wrap items-center justify-between mx-auto px-4 md:px-10">
        <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="{{ asset('image/logo-perpus.png') }}" alt="Logo Perpus Ngablak" class="h-20" />
        </a>
        <button data-collapse-toggle="navbar-default" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-default" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
            </svg>
        </button>
        <div class="hidden w-full md:block md:w-auto" id="navbar-default">
            <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                <li class="mx-4 my-4 md:my-0">
                    <a href="/" class="text-md hover:text-cyan-400 duration-300 border-b border-transparent hover:border-b-sky-400 hover:border-b-2 transition-all">Home</a>
                </li>
                <li class="mx-4 my-4 md:my-0">
                    <a href="/caribuku" class="text-md hover:text-cyan-400 duration-300 border-b border-transparent hover:border-b-sky-400 hover:border-b-2 transition-all"> Pencarian Buku </a>
                </li>
                <li class="mx-4 my-4 md:my-0">
                    <a href="/berita" class="text-md hover:text-cyan-400 duration-300 border-b border-transparent hover:border-b-sky-400 hover:border-b-2 transition-all">Berita </a>
                </li>
                <li class="mx-4 my-4 md:my-0">
                    <a href="/admin/signin" class="text-md hover:text-cyan-400 duration-300 border-b border-transparent hover:border-b-sky-400 hover:border-b-2 transition-all">Login</a>
                </li>
            </ul>
        </div>
    </div>
</nav>