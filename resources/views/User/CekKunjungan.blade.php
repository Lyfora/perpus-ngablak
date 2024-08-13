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
    <title>Cari Buku</title>
    <link rel="icon" type="image/png" href="{{ asset('image/logo-kabupaten.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-[Poppins] h-screen text-black">
    @include('User.Components.Navbar.Navbar')
    @include('Components.Toast.index')
    @php
    // get params
    $sort_by = request()->get('sort_by');
    $sort = request()->get('sort');
    $search = request()->get('search');
    $page = request()->get('page') ?? 1;

    @endphp
    <div class="">
        <section class="bg-center bg-no-repeat bg-gray-700 bg-blend-multiply bg-cover" style="background-image: url('{{ asset('image/perpustakaan-lorong.jpg') }}');">
            <div class="px-4 mx-auto max-w-screen-xl text-center py-24 lg:py-56">
                <h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-white md:text-5xl lg:text-6xl">Cari Buku Kesayanganmu!</h1>
                @include('User.Components.SearchCode.search')
            </div>
        </section>

        @if($search)


        <section id="Hasil Pencarian" class=" bg-slate-200 py-10">
            <div class="container mx-auto">
                <h2 class="text-xl font-medium text-center mb-2">Hasil Pencarian</h2>
                <h2 class="text-3xl text-blue-600 font-medium text-center mb-5">{{$search}}</h2>
                @if(!$buku->isEmpty())
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    @foreach ($buku as $buku_data)
                    <a href="/caribuku/{{$buku_data->slug}}">
                        <div class="rounded overflow-hidden shadow-lg bg-white p-4 text-center border-2 border-transparent hover:border-blue-500 transition duration-300">
                            <img class="w-full h-[180px] object-cover" src="{{$buku_data->thumbnail}}" alt="Image">
                            <h3 class="text-xl mt-4">{{$buku_data->title}}</h3>
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
                    </a>
                    @endforeach
                </div>
                <nav aria-label="Page navigation example" class="mt-3">
                    <ul class="flex items-center -space-x-px h-8 text-sm">
                        <li>
                            <a href={{ route('user.search', array_merge(['page' => $page == 1 ? $page : $page - 1, 'search' => $search, 'sort_by' => $sort_by, 'sort' => $sort])) }} class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <span class="sr-only">Previous</span>
                                <svg class="w-2.5 h-2.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4" />
                                </svg>
                            </a>
                        </li>
                        @for ($i = 1; $i <= $buku->lastPage(); $i++)
                            @if ($i == $buku->currentPage())
                            <li>
                                <a href={{ route('user.search', array_merge(['page' => $i, 'search' => $search, 'sort_by' => $sort_by, 'sort' => $sort])) }} class="flex items-center justify-center px-3 h-8 leading-tight text-blue-600 bg-blue-50 border border-blue-300 dark:border-gray-700 dark:bg-gray-700 dark:text-white">{{ $i }}</a>
                            </li>
                            @else
                            <li>
                                <a href={{ route('user.search', array_merge(['page' => $i, 'search' => $search, 'sort_by' => $sort_by, 'sort' => $sort])) }} class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">{{ $i }}</a>
                            </li>
                            @endif
                            @endfor
                            <li>
                                <a href={{ route('user.search', array_merge(['page' => $page == $buku->lastPage() ? $page : $page + 1, 'search' => $search, 'sort_by' => $sort_by, 'sort' => $sort])) }} class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                    <span class="sr-only">Next</span>
                                    <svg class="w-2.5 h-2.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                                    </svg>
                                </a>
                            </li>
                    </ul>
                </nav>
                @else
                <h3 class="text-xl font-medium text-center mb-2"> Buku Tidak Tersedia </h3>
                @endif
            </div>
        </section>
        @endif

        @include('User.Components.Footer.Footer')



</body>

</html>