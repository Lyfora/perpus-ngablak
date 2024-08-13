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

<body>
    @include('User.Components.Navbar.Navbar')
    <div class="md:px-12">
        <div class="">
            <div class="p-4 bg-white rounded-lg">
                <div class="inline-flex items-center rounded-md shadow-sm" role="group">
                    <button type="button"
                        class="inline-flex px-2 py-2 text-sm font-medium text-gray-900 bg-white rounded-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                        <a href={{ url('/') }} class="inline-flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-left"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M15 6l-6 6l6 6" />
                            </svg>
                            <span class="ms-2">Detail Berita</span>

                        </a>
                    </button>
                </div>
                <br />
                <div class="relative overflow-x-auto px-5 min-h-screen w-full">
                    <h1 class="text-2xl md:text-4xl font-bold text-gray-900 dark:text-white mt-5">{{ $news->title }}
                    </h1>
                    <img src="{{ url($news->thumbnail) }}" alt="thumbnail"
                        class="w-full h-40 md:h-96 mt-8 rounded-lg object-contain">
                    <div class="mt-8">{!! $news->content !!}</div>
                </div>
            </div>
        </div>
    </div>
    @include('User.Components.Footer.Footer')
</body>