<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('image/logo-kabupaten.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <title>{{ $title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{ isset($js) ? $js : '' }}
</head>

<body class="bg-gray-100 font-[Poppins]">

    @include('Components.Sidebar.Index')
    @include('Components.Toast.Index')

</body>

</html>