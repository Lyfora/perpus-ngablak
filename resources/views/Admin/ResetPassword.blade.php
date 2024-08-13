<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-full">
    <div class="min-h-screen flex">
        <div class="w-full md:w-2/5 flex flex-col justify-center items-center px-12">
            <img class="w-1/2" src={{ url('image/Logo-Desnet.png') }} alt="">
            <h1 class="text-4xl font-bold text-blue-700">Lupa Password</h1>
            <p class="text-gray-500">Masukkan Password Baru Untuk Mengganti Password</p>
            <form class="mt-8 space-y-6 w-full" action={{ route('action-reset-password') }} method="POST">
                @csrf
                @method('POST')
                <div class="grid gap-6">
                    <input type="hidden" id="hidden" name="token" value="{{ $token }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Masukkan Password" required>
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Password Baru</label>
                        <input type="password" id="password" name="password"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Masukkan Password" required>
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Konfirmasi Password</label>
                        <input type="password" id="password" name="password_confirmation"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Masukkan Password" required>
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        <p>Password harus terdiri dari 8 karakter, 1 huruf besar, 1 huruf kecil, 1 angka, dan 1 karakter
                            khusus.</p>
                    </div>
                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Reset
                        Password</button>
                </div>

            </form>
        </div>
        <div class="hidden md:w-3/5 md:block">
            <img class="h-screen w-full object-cover" src={{ url('image/Login-Image.png') }} alt="">
        </div>
    </div>
    </div>
    @include('Components.Toast.Index')
</body>

</html>
