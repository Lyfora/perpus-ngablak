<x-AdminLayout.Index>
    <x-slot name="title">
        {{ __('Tambah Buku') }}
    </x-slot>
    <x-slot name="js">

    </x-slot>
    <div class="p-4 sm:ml-64">
        <div class="p-4 bg-white rounded-lg mt-14">
            <div class="inline-flex items-center rounded-md shadow-sm" role="group">
                <button type="button" class="inline-flex px-2 py-2 text-sm font-medium text-gray-900 bg-white rounded-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                    <a href={{ url('admin/buku') }} class="inline-flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-left" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M15 6l-6 6l6 6" />
                        </svg>
                        <span class="ms-2">Tambah Buku</span>

                    </a>
                </button>
            </div>
            <form action={{ route('buku.create') }} method="POST" enctype="multipart/form-data" class="relative grid gap-6 overflow-x-auto">
                @csrf
                <div class="relative grid gap-6 overflow-x-auto px-5">
                    <div>
                        <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Judul<span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="contoh : Naruto Volume 72" required />
                    </div>
                    <div>
                        <label for="slug" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Slug<span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="slug" name="slug" value="{{ old('slug') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="otomatis terisi dari judul" required />
                    </div>
                    <div>
                        <label for="volume" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Volume<span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="volume" name="volume" value="{{ old('title') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Contoh : 1, jika tidak ada isikan '-'" required />
                    </div>
                    <div>
                        <label for="penerbit" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Penerbit<span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="penerbit" name="penerbit" value="{{ old('title') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="contoh: PT Elexmedia Komputindo" required />
                    </div>
                    <div>
                        <label for="tahun_buku" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Tahun Buku<span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="tahun_buku" name="tahun_buku" value="{{ old('tahun_buku') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="contoh: 2021" required />
                    </div>
                    <div>
                        <label for="lokasi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Lokasi<span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="lokasi" name="lokasi" value="{{ old('lokasi') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="contoh: A101" required />
                    </div>
                    <div>
                        <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Pilih Kategori<span class="text-red-500">*</span>
                        </label>
                        <select id="pengarang" name="kategori" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="">Pilih Kategori</option>
                            @foreach ($kategori as $kategori_data)
                            {
                            <option value="{{ $kategori_data->id }}"> {{ $kategori_data->name }}</option>
                            }
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Pilih Pengarang<span class="text-red-500">*</span>
                        </label>
                        <select id="pengarang" name="pengarang" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="">Pilih Pengarang</option>
                            @foreach ($pengarang as $pengarang_data)
                            {
                            <option value="{{ $pengarang_data->id }}"> {{ $pengarang_data->name }}</option>
                            }
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Thumbnail<span class="text-red-500">*</span>
                        </label>
                        <div class="flex items-center">
                            <label for="dropzone-file" class="flex flex-col items-center justify-center w-64 h-48 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                <div id="default-image" class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click
                                            to upload</span> or drag and drop</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 5 Mb)
                                    </p>
                                </div>
                                <img id="image-preview" class="object-contain w-64 h-48 rounded-lg hidden" />
                                <input id="dropzone-file" name="thumbnail" type="file" class="hidden" accept="image/jpeg, image/png, image/jpg" value="{{ old('thumbnail') }}" />
                            </label>

                        </div>
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

<script>
    const fileInput = document.getElementById('dropzone-file');
    const imagePreview = document.getElementById('image-preview');

    // Tambahkan event listener untuk perubahan pada input file
    fileInput.addEventListener('change', function() {
        // Pastikan ada file yang dipilih
        if (fileInput.files && fileInput.files[0]) {
            // hidden default image
            document.getElementById('default-image').style.display = 'none';
            document.getElementById('image-preview').style.display = 'block';
            // Buat objek FileReader untuk membaca file
            const reader = new FileReader();

            // Atur fungsi callback saat file telah dibaca
            reader.onload = function(e) {
                // Atur sumber gambar pratinjau ke URL data
                imagePreview.src = e.target.result;
                // Tampilkan gambar pratinjau
                imagePreview.style.display = 'block';
            };

            // Baca file sebagai URL data
            reader.readAsDataURL(fileInput.files[0]);
        }
    });

    // create slug
    const title = document.getElementsByName('title')[0];
    const slug = document.getElementsByName('slug')[0];

    // event listener
    title.addEventListener('input', function() {
        slug.value = title.value.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
    });
</script>