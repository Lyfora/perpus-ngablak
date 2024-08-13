<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <title>{{$buku->title}}</title>
    <link rel="icon" type="image/png" href="{{ asset('image/logo-kabupaten.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
    @include('User.Components.Navbar.Navbar')
    <div class="container mx-auto my-10 p-5 bg-white shadow-lg rounded-lg">
        <!-- Add Back Button -->
        <div class="mb-5">
            <button onclick="history.back()" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-700">
                &larr; Back
            </button>
        </div>
        <div class="flex flex-wrap items-center">
            <!-- Book Image -->
            <div class="w-1/3 p-5">
                <img src="{{ $buku->thumbnail }}" alt="{{ "Thumbnail" }}" class=" rounded-lg " style="height: 500px;">
            </div>
            <!-- Book Information -->
            <div class="w-2/3  p-5">
                <h2 class="text-3xl font-bold mb-3">{{ $buku->title }}</h2>
                <p class=" text-lg mb-2"><strong>Pengarang :</strong> {{ $pengarang->name }}</p>
                <p class="text-lg mb-2"><strong>Penerbit :</strong> {{ $buku->penerbit }}</p>
                <p class="text-lg mb-2"><strong>Kategori :</strong> {{ $kategori->name }}</p>
                <p class="text-lg mb-2"><strong>Tahun Buku :</strong> {{ $buku->tahun_buku }}</p>
                <p class="text-lg mb-2"><strong>Lokasi Buku :</strong> {{ $buku->lokasi }}</p>
                <p class="text-lg mb-2"><strong>Status Buku :</strong>
                    @if ($buku->status_code=='tersedia')
                    <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">
                        Tersedia
                    </span>
                </p>
                @else
                <span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                    Dipinjam
                </span></p>
                @endif
            </div>
        </div>
    </div>
    @include('User.Components.Footer.Footer')
</body>

</html>