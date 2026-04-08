<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Game Besar Maniac XIV</title>
    
    {{-- Icon --}}
    <link rel="icon" href="{{ asset('asset2025/Icon.ico') }}" type="image/x-icon">
    
    {{-- Tailwind --}}
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        
    {{-- Font --}}
    <link rel="stylesheet" href="{{ asset('css/font.css') }}">

    {{-- Internal CSS --}}
    @yield("style")
    <style>
        body, html{
            margin: 0;
            padding: 0;
        }
        :root {
            --ff-dalek: "dalek";        {{-- Tidak jalan --}}
        }
        .c-bg-white{
            background-color: rgba(255, 255, 255, 0.6)    
        }
    </style>
</head>
<body class="bg-gradient-to-t from-[#E2E3C4] to-[#FAFBF6]">
    <div class="absolute inset-0 z-0 bg-no-repeat bg-bottom bg-contain w-screen h-screen" style="background-image: url('{{ asset('asset2025/gameBesar/bg.png') }}');"></div>

    <div class="flex justify-center items-center w-screen h-screen absolute">
        {{-- Isi Konten --}}
        @yield("content")
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@yield("script")
</html>