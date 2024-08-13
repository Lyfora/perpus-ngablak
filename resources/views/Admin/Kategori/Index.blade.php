<x-AdminLayout.Index>
    <x-slot name="title">
        {{ __('Daftar Kategori') }}
    </x-slot>
    <div class="p-4 sm:ml-64">
        <div class="p-4 border-2 bg-white rounded-lg dark:border-gray-700 mt-14">
            <h1 class="font-medium"> Daftar Kategori</h1>
            @include('Admin.Kategori.Table')
        </div>
    </div>
</x-AdminLayout.Index>