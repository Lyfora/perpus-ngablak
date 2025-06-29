<x-AdminLayout.Index>
    <x-slot name="title">
        {{ __('Edit Kategori') }}
    </x-slot>
    <x-slot name="js">

    </x-slot>
    <div class="p-4 sm:ml-64">
        <div class="p-4 bg-white rounded-lg mt-14">
            <div class="inline-flex items-center rounded-md shadow-sm" role="group">
                <button type="button" class="inline-flex px-2 py-2 text-sm font-medium text-gray-900 bg-white rounded-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                    <a href={{ url('admin/kategori') }} class="inline-flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-left" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M15 6l-6 6l6 6" />
                        </svg>
                        <span class="ms-2">Edit Kategori</span>

                    </a>
                </button>
            </div>
            <form action={{ route('kategori.action-edit') }} method="POST" enctype="multipart/form-data" class="relative grid gap-6 overflow-x-auto">
                @csrf
                @method('PUT')
                <div class="relative grid gap-6 overflow-x-auto px-5">
                    <div>
                        <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Judul<span class="text-red-500">*</span>
                        </label>
                        <input type="hidden" id="id" name="id" value="{{ $kategori->id }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Judul Kategori" required />
                        <input type="text" id="name" name="name" value="{{ $kategori->name }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Judul Kategori" required />
                    </div>
                    <div>
                        <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Image<span class="text-red-500">*</span>
                        </label>
                        <div class="flex items-center">
                            <label for="dropzone-file" class="flex flex-col items-center justify-center w-64 h-48 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                <div id="default-image" class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click
                                            to upload</span> or drag and drop</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 5mb)
                                    </p>
                                </div>
                                <img id="image-preview" class="object-contain w-64 h-48 rounded-lg hidden" src={{ $kategori->image }} />
                                <input id="dropzone-file" name="image" type="file" class="hidden" accept="image/jpeg, image/png, image/jpg" />
                            </label>
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
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

    if (imagePreview.src) {
        document.getElementById('default-image').style.display = 'none';
        document.getElementById('image-preview').style.display = 'block';
    }

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
</script>