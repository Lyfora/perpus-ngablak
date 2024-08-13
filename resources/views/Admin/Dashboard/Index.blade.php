@php
$filter = [
'start_month' => request()->get('start_month') ?? 0,
'end_month' => request()->get('end_month') ?? date('m') - 1,
'year' => request()->get('year') ?? date('Y'),
];
@endphp

<x-AdminLayout.index>
    <x-slot name="title">
        {{ __('Dashboard') }}
    </x-slot>
    <x-slot name="js">
        @vite(['resources/js/dashboard.js'])
    </x-slot>
    <div class="flex flex-row flex-wrap mt-14 sm:ml-64 ">
        <div class="flex flex-col flex-wrap w-full mx-4 my-4 bg-white p-4 gap-4 rounded-lg shadow dark:bg-gray-800">
            <div class="flex flex-row flex-wrap items-center justify-between gap-4">
                <h1 class="text-2xl font-medium text-gray-900 dark:text-white">Dashboard</h1>
                <div class="flex flex-row items-center">
                    <h1 class="text-2xl font-medium text-gray-900 dark:text-white" id="title"></h1>
                    <div id="accordion-color" data-accordion="open" class="ml-3" data-active-classes="bg-blue-100 dark:bg-gray-800 text-blue-600 dark:text-white">
                        <button type="button" id="accordion-color-heading-1" class="flex items-center justify-between w-full p-2 font-medium text-gray-500 border border-gray-200 rounded-lg focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 dark:border-gray-700 dark:text-gray-400 hover:bg-blue-100 dark:hover:bg-gray-800" data-accordion-target="#accordion-color-body-1" aria-expanded="false" aria-controls="accordion-color-body-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-filter-filled" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M20 3h-16a1 1 0 0 0 -1 1v2.227l.008 .223a3 3 0 0 0 .772 1.795l4.22 4.641v8.114a1 1 0 0 0 1.316 .949l6 -2l.108 -.043a1 1 0 0 0 .576 -.906v-6.586l4.121 -4.12a3 3 0 0 0 .879 -2.123v-2.171a1 1 0 0 0 -1 -1z" stroke-width="0" fill="currentColor" />
                            </svg>
                            Filter
                        </button>
                    </div>
                </div>

            </div>

            <div id="accordion-color-body-1" class="hidden" aria-labelledby="accordion-color-heading-1">
                <div class="p-5 border border-gray-200 dark:border-gray-700 dark:bg-gray-900 rounded-lg">
                    <form id="form-filter" class="flex flex-col flex-wrap w-full my-4 bg-white gap-4" action={{ route('dashboard') }}>
                        <div class="flex flex-col md:flex-row flex-wrap w-full bg-white gap-4">
                            <div class="w-full md:w-1/4">
                                <label for="status" class="text-sm font-medium text-gray-900 dark:text-white">Bulan
                                    Awal</label>
                                <br />
                                <div class="relative">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                        </svg>
                                    </div>
                                    <input name="start_month" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Pilih Tanggal Mulai">
                                </div>
                            </div>
                            <div class="w-full md:w-1/4">
                                <label for="status" class="text-sm font-medium text-gray-900 dark:text-white">Bulan
                                    Akhir</label>
                                <br />
                                <div class="relative">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                        </svg>
                                    </div>
                                    <input name="end_month" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Pilih Tanggal Mulai">
                                </div>
                            </div>
                            <div class="w-full md:w-1/4">
                                <label for="status" class="text-sm font-medium text-gray-900 dark:text-white">Tahun</label>
                                <br />
                                <div class="relative">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                        </svg>
                                    </div>
                                    <input name="year" type="text" value="{{ $filter['year'] }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Pilih Tahun">
                                </div>
                            </div>
                        </div>
                        <div class="mt-5 flex flex-row">
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                Terapkan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="flex flex-col md:flex-row gap-4 md:gap-0 flex-wrap sm:ml-64">
        <div class="px-4 w-full lg:w-1/3">
            <div class="p-4 flex flex-row items-center justify-between gap-4 border-2 bg-white rounded-lg dark:border-gray-700">
                <div class="flex flex-col">
                    <h1 class="font-medium">Jumlah Buku</h1>
                    <h1 class="text-4xl font-bold">{{ $dashboard->total_buku }}</h1>
                </div>
                <div class="inline-flex items-center justify-center flex-shrink-0 w-16 h-16 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
                    <svg fill="#000000" viewBox="0 0 14 14" role="img" focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" class="w-10 h-10">
                        <path d="M 6.55466,11.542 C 6.10897,11.0187 5.36501,10.459 4.6445,10.1049 3.91698,9.7473 3.22595,9.5487 2.44138,9.4719 2.28669,9.4569 2.15844,9.4429 2.15639,9.4409 c -0.002,0 0.002,-1.6151 0.01,-3.5846 l 0.0132,-3.5808 0.14284,0.014 c 0.87708,0.087 1.85601,0.4184 2.59669,0.8803 0.63833,0.398 1.29749,1.0126 1.71774,1.6015 l 0.10576,0.1482 0,3.4014 c 0,1.8707 -0.008,3.401 -0.0176,3.4007 -0.01,-3e-4 -0.0861,-0.081 -0.16992,-0.1794 z m 0.72656,-3.2297 0,-3.4156 0.20424,-0.2729 C 7.74623,4.2754 8.27075,3.7505 8.61758,3.491 9.54472,2.7971 10.55044,2.405 11.70505,2.287 l 0.14648,-0.015 0,3.5858 0,3.5859 -0.16992,0.016 C 10.0739,9.6093 8.6801,10.2726 7.5899,11.4068 l -0.30868,0.3212 0,-3.4156 z m 0.9961,3.1835 c 0.63101,-0.592 1.46635,-1.0624 2.30546,-1.2985 0.4391,-0.1235 1.01012,-0.2097 1.38918,-0.2097 0.19874,0 0.30898,-0.043 0.37116,-0.1451 0.0468,-0.077 0.0473,-0.1101 0.0474,-3.0157 l 8e-5,-2.9382 0.0879,0.016 c 0.0483,0.01 0.18544,0.048 0.30468,0.086 l 0.2168,0.069 0,3.6669 c 0,2.0168 -0.008,3.6669 -0.0179,3.6669 -0.01,0 -0.15489,-0.031 -0.32227,-0.069 -0.66143,-0.149 -1.20614,-0.2002 -1.92152,-0.1809 -0.86772,0.024 -1.54209,0.145 -2.34375,0.422 l -0.30469,0.1053 0.1875,-0.1759 z m -2.67188,0.057 C 5.27252,11.4336 4.7227,11.2931 4.35153,11.2325 c -0.50468,-0.082 -0.85286,-0.1038 -1.4714,-0.09 -0.61458,0.013 -0.98632,0.056 -1.49344,0.1711 -0.1418,0.032 -0.28682,0.065 -0.32227,0.072 l -0.0644,0.014 1.1e-4,-3.6767 1.2e-4,-3.6768 0.27529,-0.08 c 0.1514,-0.044 0.28847,-0.085 0.30458,-0.09 0.0233,-0.01 0.0293,0.589 0.0293,2.9349 0,3.2057 -0.007,3.027 0.12978,3.1169 0.0476,0.031 0.1465,0.045 0.42893,0.062 1.12246,0.064 2.18752,0.4409 3.05702,1.0822 0.1875,0.1383 0.63749,0.5181 0.66328,0.5598 0.018,0.029 0.006,0.026 -0.28292,-0.078 z" />
                    </svg>
                </div>
            </div>
        </div>
        <div class="px-4 w-full lg:w-1/3">
            <div class="p-4 flex flex-row items-center justify-between gap-4 border-2 bg-white rounded-lg dark:border-gray-700">
                <div class="flex flex-col">
                    <h1 class="font-medium">Buku Tersedia</h1>
                    <h1 class="text-4xl font-bold">{{ $dashboard->total_tersedia }}</h1>
                </div>
                <div class="inline-flex items-center justify-center flex-shrink-0 w-16 h-16 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
                    <svg class="w-10 h-10" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                    </svg>
                </div>
            </div>
        </div>
        <div class="px-4 w-full  lg:w-1/3">
            <div class="p-4 flex flex-row items-center justify-between gap-4 border-2 bg-white rounded-lg dark:border-gray-700">
                <div class="flex flex-col">
                    <h1 class="font-medium">Buku Dipinjam</h1>
                    <h1 class="text-4xl font-bold">{{ $dashboard->total_dipinjam }}</h1>
                </div>
                <div class="inline-flex items-center justify-center flex-shrink-0 w-16 h-16 text-red-500 bg-red-100 rounded-lg dark:bg-red-800 dark:text-red-200">
                    <svg class="w-10 h-10" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>




</x-AdminLayout.index>