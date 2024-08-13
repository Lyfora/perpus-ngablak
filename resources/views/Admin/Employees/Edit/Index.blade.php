<x-AdminLayout.Index>
    <x-slot name="title">
        {{ __('Edit Berita') }}
    </x-slot>
    <div class="p-4 sm:ml-64">
        <div class="p-4 bg-white rounded-lg mt-14">
            <div class="inline-flex items-center rounded-md shadow-sm" role="group">
                <button type="button"
                    class="inline-flex px-2 py-2 text-sm font-medium text-gray-900 bg-white rounded-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                    <a href={{ url('admin/employees') }} class="inline-flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-left"
                            width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M15 6l-6 6l6 6" />
                        </svg>
                        <span class="ms-2">Edit PIC</span>

                    </a>
                </button>
            </div>
            <form action={{ route('employees.action-edit') }} method="POST" enctype="multipart/form-data"
                class="relative grid gap-6 overflow-x-auto">
                @csrf
                @method('PUT')
                <div class="relative grid gap-6 overflow-x-auto px-5">
                    <div>
                        <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Nama<span class="text-red-500">*</span>
                        </label>
                        <input type="hidden" id="id" name="id" value="{{ $employee->id }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Judul Berita" required />
                        <input type="text" id="title" name="name" value="{{ $employee->name }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Nama Pengguna" required />
                    </div>
                    <div>
                        <button type="submit"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
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
