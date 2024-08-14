<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <title>Perpustakaan Desa Ngablak</title>
    <link rel="icon" type="image/png" href="{{ asset('image/logo-kabupaten.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-[Poppins]">
    @include('User.Components.Navbar.Navbar')
    @include('Components.Toast.index')
    @if (session('invalid'))
    @include('User.Components.Toast.invalid')
    @endif
    @if (session('finish'))
    @include('User.Components.Toast.finish')
    @endif

    <!-- Hero Section Start -->
    <section id="home" class=" bg-white w-full ">
        <div class="container mx-auto">
            <div class="flex flex-wrap py-8">
                <div class="w-full self-center px-4 lg:w-1/2">

                    <h1 class=" font-semibold text-2xl">
                        Selamat Datang di
                    </h1>
                    <h1 class="font-semibold text-sky-400 text-4xl">
                        Perpustakaan Desa Ngablak
                    </h1>
                    <h2 class="font-medium my-5 mb-3 text-black ">Silahkan klik tombol "Cari Buku" untuk mencari buku yang kamu ingin baca </h2>

                    <a href="/caribuku" class=" text-center block my-3 text-base font-semibold rounded-3xl text-white bg-sky-400 py-3 px-12 hover:shadow-lg hover:bg-sky-700 hover:duration-200 transisition delay-100 ease-in-out"> Cari Buku</a>
                </div>
                <div class="w-full self-end px-6 lg:w-1/2">
                    <!-- <div class="mt-10">
                        <img src="images/company_visit.jpg" alt="company" class="relative max-w-full mx-auto w-[400px] h-[300px]">
                    </div> -->
                    <div class="w-full rounded overflow-hidden p-5">
                        <img class="w-full" src="{{ asset('image/vector-perpus.png')}}" alt="vector-perpus">
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- Section Kategori Buku -->
    <section id="Genre" class=" bg-slate-200 py-10">
        <div class="container mx-auto">
            <h2 class="text-xl font-medium text-center mb-2">Kategori Buku Di</h2>
            <h2 class="text-3xl text-blue-600 font-medium text-center mb-5">Perpustakaan Desa Ngablak</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                @foreach($kategori as $kategori_data)
                <a href="/kategori/{{$kategori_data->name}}">
                    <div class="max-w-sm rounded overflow-hidden shadow-lg bg-white p-4 text-center border-2 border-transparent hover:border-blue-500 transition duration-300">
                        <img class="w-full h-[180px] object-cover" src="{{$kategori_data->image}}" alt="Image">
                        <h3 class="text-xl mt-4">{{$kategori_data->name}}</h3>
                    </div>
                </a>
                @endforeach
            </div>
    </section>

    <!-- Section Buku Terbaru -->
    <section id="Genre" class=" bg-white py-10">
        <div class="container mx-auto">
            <h2 class="text-xl font-medium text-center mb-2">Buku Terbaru Di</h2>
            <h2 class="text-3xl text-blue-600 font-medium text-center mb-5">Perpustakaan Desa Ngablak</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                @foreach($buku as $buku_data)
                <a href="/detailbuku/{{$buku_data->slug}}">
                    <div class="max-w-sm rounded overflow-hidden shadow-lg bg-white p-4 text-center border-2 border-transparent hover:border-blue-500 transition duration-300">
                        <img class="w-full h-[180px] object-cover" src="{{$buku_data->thumbnail}}" alt="Image">
                        <h3 class="text-xl mt-4">{{$buku_data->title}}</h3>
                        <h3 class="text-xl mt-4">{{$buku_data->pengarang}}</h3>
                    </div>
                </a>
                @endforeach
            </div>
    </section>
    <!-- Section Berita -->
    <section id="warning" class=" bg-slate-200 py-10">
        <div class="container mx-auto">
            <h2 class="text-xl font-medium text-center mb-2">Berita Terbaru di</h2>
            <h2 class="text-3xl text-blue-600 font-medium text-center mb-5">Perpustakaan Desa Ngablak</h2>
            <div class="flex flex-wrap items-stretch">
                @if (count($news) == 1)
                @foreach ($news as $newsItems)
                <div class="w-full px-5">
                    <div class="block rounded-lg bg-white shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] dark:bg-neutral-700">
                        <a href="{{ url('/berita/' . $newsItems->id) }}">
                            <img class="rounded-t-md object-cover h-[200px]" src="{{ url($newsItems->thumbnail) }}" alt="" />
                        </a>
                        <div class="p-6 bg-white text-black shadow-sm">
                            <h5 class="mb-2 text-xl font-medium leading-tight  inline">
                                {{ $newsItems->title }}
                            </h5>
                            <div>
                                <ion-icon name="calendar-outline" class=""></ion-icon>
                                <p class=" inline">{{ $newsItems->published_at }}</p>

                            </div>
                            <p class="mb-4 text-base">
                                @php
                                $htmlContent = '
                                {{ $newsItems->content }}';

                                // Strip HTML tags
                                $plaintext = strip_tags($htmlContent);

                                // Get excerpt of desired length
                                $excerpt = Str::limit($plaintext, 20); // Change 20 to desired character count
                                @endphp
                                {{ $excerpt }}
                            </p>
                            <a href="url('/berita/' . $newsItems->id)" class="hover:text-sky-400 ">
                                Lihat Selengkapnya..
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                @foreach ($news as $newsItems)
                @if ($loop->first)
                <div class="lg:w-2/3 px-5">
                    <div class="block rounded-lg bg-white shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] dark:bg-neutral-700">
                        <a href="{{ url('/berita/' . $newsItems->id) }}">
                            <img class="block w-[1120px] rounded-t-lg h-[480px]" src="{{ url($newsItems->thumbnail) }}" alt="image1" />
                        </a>
                        <div class="p-6 bg-white text-black shadow-sm">
                            <h5 class="mb-2 text-xl font-medium leading-tight  inline">
                                {{ $newsItems->title }}
                            </h5>
                            <div>
                                <ion-icon name="calendar-outline" class=""></ion-icon>
                                <p class=" inline">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 inline -mt-1 mr-2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                                    </svg>
                                    {{ Carbon\Carbon::parse($newsItems->published_at)->locale('id_ID')->format('d F Y') }}
                                </p>

                            </div>
                            <p class="mt-2 text-base">
                                @php
                                $htmlContent = $newsItems->content;
                                // Strip HTML tags
                                $plaintext = strip_tags($htmlContent);

                                // Get excerpt of desired length
                                $excerpt = Str::limit($plaintext, 20); // Change 20 to desired character count
                                @endphp
                                {{ $excerpt }}
                            </p>
                            <a href="{{ url('/berita/' . $newsItems->id) }}" class="text-blue-600 hover:text-blue-800">Lihat Selengkapnya..</a>
                        </div>
                    </div>
                </div>
                <div class="lg:w-1/3 px-5 w-full mt-4 lg:mt-0">
                    @else
                    <!-- Card 1 -->

                    <div class="rounded-lg bg-white shadow-lg mb-5 flex flex-col">
                        <div class="flex-none fill  overflow-hidden">
                            <a href="{{ url('/berita/' . $newsItems->id) }}">
                                <img class="aspect-video rounded-t-lg object-scale-down " src="{{ $newsItems->thumbnail }}" alt="" />
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
                            <a href="{{ url('/berita/' . $newsItems->id) }}" class="text-blue-600 hover:text-blue-800">Lihat Selengkapnya..</a>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
            @endif
    </section>
    @include('User.Components.Footer.Footer')
</body>

</html>