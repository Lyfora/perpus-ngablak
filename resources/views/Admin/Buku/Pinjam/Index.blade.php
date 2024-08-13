<x-AdminLayout.Index>
    <x-slot name="title">
        {{ __('Pinjam Buku') }}
    </x-slot>
    <x-slot name="js">

    </x-slot>
    <div class="p-4 sm:ml-64">
        <div class="p-4 bg-white rounded-lg mt-14">
            <div class="inline-flex items-center rounded-md shadow-sm" role="group">
                <button type="button" class="inline-flex px-2 py-2 text-sm font-medium text-gray-900 bg-white rounded-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                    <a href={{ url('admin/pinjam') }} class="inline-flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-left" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M15 6l-6 6l6 6" />
                        </svg>
                        <span class="ms-2">Pinjam Buku</span>

                    </a>
                </button>
            </div>
            <div class="flex flex-wrap items-center">
                <!-- Book Image -->
                <div class="w-1/3  p-5">
                    <img src="{{ $buku->thumbnail}}" alt="{{ $buku->title }}" class=" rounded-lg " style="height: 300px;">
                </div>
                <!-- Book Information -->
                <div class="w-2/3  p-5">
                    <h2 class="text-3xl font-bold mb-3">{{ $buku->title }}</h2>
                    <p class=" text-lg mb-2"><strong>Pengarang :</strong> {{ $pengarang->name }}</p>
                    <p class="text-lg mb-2"><strong>Penerbit :</strong> {{ $buku->penerbit }}</p>
                    <p class="text-lg mb-2"><strong>Kategori :</strong> {{ $kategori->name }}</p>
                    <p class="text-lg mb-2"><strong>Tahun Buku :</strong> {{ $buku->tahun_buku }}</p>
                    <p class="text-lg mb-2"><strong>Lokasi Buku :</strong> {{ $buku->lokasi }}</p>
                </div>
            </div>
            <form action={{ route('buku.action-pinjam') }} method="POST" enctype="multipart/form-data" class="relative grid gap-6 overflow-x-auto">
                @csrf
                @method('PUT')
                <div>
                    <input type="text" id="id" name="id" value="{{$buku->id}}" class="hidden" required />
                </div>
                <div>
                    <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Nama Peminjam<span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="nama_peminjam" name="nama_peminjam" placeholder="contoh : Ariana" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="contoh : Naruto Volume 72" required />
                </div>
                <div>
                    <button class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                        Simpan
                    </button>
                </div>
            </form>

        </div>


    </div>

</x-AdminLayout.Index>