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
    <title>Berita Perpustakaan Ngablak</title>
    <link rel="icon" type="image/png" href="{{ asset('image/logo-kabupaten.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

@php
// get params
$filter = [
'limit' => request()->get('limit'),
'status_code' => request()->get('status_code') ?? [],
'start_created_at' => request()->get('start_created_at'),
'end_created_at' => request()->get('end_created_at'),
];
$sort_by = request()->get('sort_by');
$sort = request()->get('sort');
$search = request()->get('search');
$page = request()->get('page') ?? 1;

@endphp

<body class="font-[Poppins] h-screen text-black">
    @include('User.Components.Navbar.Navbar')
    @include('Components.Toast.index')
    <div class="min-h-screen">


        <div class="bg-gray-900">
            <div class="mx-auto text-center py-8 px-8">
                <h1 class="font-semibold text-sky-400 text-4xl">
                    Cari Berita
                </h1>
                @include('User.Components.SearchNews.search')
            </div>
        </div>
        <div class="container flex flex-col mx-auto px-4 md:px-10 py-8 gap-4">
            <div class="container grid grid-cols-1 lg:grid-cols-3 gap-4">
                @foreach ($news as $newsItems)
                <div class="max-w-sm rounded overflow-hidden shadow-lg bg-white p-4 border-2 border-transparent hover:border-blue-500 transition duration-300">
                    <div class="w-full">
                        <a href="{{ url('/berita/' . $newsItems->id) }}">
                            <img class="w-full aspect-video rounded-t-lg object-scale-down h-100" src="{{ $newsItems->thumbnail }}" alt="" />
                        </a>
                    </div>
                    <div class="px-6 py-3 text-black w-full">
                        <h5 class="text-md font-medium mb-1">{{ $newsItems->title }}</h5>
                        <p class="text-base mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline -mt-1 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                            </svg>
                            {{ Carbon\Carbon::parse($newsItems->published_at)->locale('id_ID')->format('d F Y') }}
                        </p>
                        <p class="text-base mb-2">
                            @php
                            $htmlContent = $newsItems->content;
                            // Strip HTML tags
                            $plaintext = strip_tags($htmlContent);

                            // Get excerpt of desired length
                            $excerpt = Str::limit($plaintext, 20); // Change 20 to desired character count
                            @endphp
                            {{ $excerpt }}
                        </p>
                        <a href="{{ url('/berita/' . $newsItems->id) }}" class="text-blue-600 hover:text-blue-800">Lihat
                            Selengkapnya..</a>
                    </div>
                </div>
                @endforeach
            </div>
            <nav aria-label="Page navigation example" class="mt-3 mx-auto">
                <ul class="flex items-center -space-x-px h-8 text-sm">
                    <li>
                        <a href={{ route('listNews', array_merge(['page' => $page == 1 ? $page : $page - 1, 'search' => $search, 'sort_by' => $sort_by, 'sort' => $sort], $filter)) }} class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            <span class="sr-only">Previous</span>
                            <svg class="w-2.5 h-2.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4" />
                            </svg>
                        </a>
                    </li>
                    @for ($i = 1; $i <= $news->lastPage(); $i++)
                        @if ($i == $news->currentPage())
                        <li>
                            <a href={{ route('listNews', array_merge(['page' => $i, 'search' => $search, 'sort_by' => $sort_by, 'sort' => $sort], $filter)) }} class="flex items-center justify-center px-3 h-8 leading-tight text-blue-600 bg-blue-50 border border-blue-300 dark:border-gray-700 dark:bg-gray-700 dark:text-white">{{ $i }}</a>
                        </li>
                        @else
                        <li>
                            <a href={{ route('listNews', array_merge(['page' => $i, 'search' => $search, 'sort_by' => $sort_by, 'sort' => $sort], $filter)) }} class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">{{ $i }}</a>
                        </li>
                        @endif
                        @endfor
                        <li>
                            <a href={{ route('listNews', array_merge(['page' => $page == $news->lastPage() ? $page : $page + 1, 'search' => $search, 'sort_by' => $sort_by, 'sort' => $sort], $filter)) }} class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
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