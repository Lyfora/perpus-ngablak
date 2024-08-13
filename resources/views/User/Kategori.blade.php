<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <title>Kategori {{$kategori}}</title>
    <link rel="icon" type="image/png" href="{{ asset('image/logo-kabupaten.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

@php
// get params

$sort_by = request()->get('sort_by');
$sort = request()->get('sort');
$page = request()->get('page') ?? 1;

@endphp

<body class="font-[Poppins] h-screen text-black">
    @include('User.Components.Navbar.Navbar')
    @include('Components.Toast.index')
    <div class="min-h-screen">
        <div class="container flex flex-col mx-auto px-4 md:px-10 py-8 gap-4">
            <div class="container grid grid-cols-1 lg:grid-cols-3 gap-4">
                @foreach ($buku as $buku_data)
                <div class="max-w-sm rounded overflow-hidden shadow-lg bg-white p-4 border-2 border-transparent hover:border-blue-500 transition duration-300">
                    <div class="w-full">
                        <a href="{{ url('/detailbuku/' . $buku_data->slug) }}">
                            <img class="w-full aspect-video rounded-t-lg object-scale-down h-100" src="{{ $buku_data->thumbnail }}" alt="" />
                        </a>
                    </div>
                    <div class="px-6 py-3 text-black w-full">
                        <h5 class="text-md font-medium mb-1">{{ $buku_data->title }}</h5>
                        <p class="text-base mb-2">
                            {{$buku_data->lokasi}}
                        </p>
                        <p class="text-base mb-2">
                            {{$buku_data->pengarang}}
                        </p>
                        @if ($buku_data->status_code=='tersedia')
                        <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">
                            Tersedia
                        </span>
                        @else
                        <span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                            Dipinjam
                        </span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            <nav aria-label="Page navigation example" class="mt-3 mx-auto">
                <ul class="flex items-center -space-x-px h-8 text-sm">
                    <li>
                        <a href={{ route('user.kategori', array_merge(['page' => $page == 1 ? $page : $page - 1, 'sort_by' => $sort_by, 'sort' => $sort, 'kategori' => $kategori])) }} class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            <span class="sr-only">Previous</span>
                            <svg class="w-2.5 h-2.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4" />
                            </svg>
                        </a>
                    </li>
                    @for ($i = 1; $i <= $buku->lastPage(); $i++)
                        @if ($i == $buku->currentPage())
                        <li>
                            <a href={{ route('user.kategori', array_merge(['page' => $i, 'sort_by' => $sort_by, 'sort' => $sort, 'kategori' => $kategori])) }} class="flex items-center justify-center px-3 h-8 leading-tight text-blue-600 bg-blue-50 border border-blue-300 dark:border-gray-700 dark:bg-gray-700 dark:text-white">{{ $i }}</a>
                        </li>
                        @else
                        <li>
                            <a href={{ route('user.kategori', array_merge(['page' => $i, 'sort_by' => $sort_by, 'sort' => $sort, 'kategori' => $kategori])) }} class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">{{ $i }}</a>
                        </li>
                        @endif
                        @endfor
                        <li>
                            <a href={{ route('user.kategori', array_merge(['page' => $page == $buku->lastPage() ? $page : $page + 1, 'sort_by' => $sort_by, 'sort' => $sort, 'kategori' => $kategori])) }} class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <span class="sr-only">Next</span>
                                <svg class="w-2.5 h-2.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                                </svg>
                            </a>
                        </li>
                </ul>
            </nav>
        </div>




    </div>
    @include('User.Components.Footer.Footer')



</body>

</html>