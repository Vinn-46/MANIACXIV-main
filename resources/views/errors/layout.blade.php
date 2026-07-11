<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <link rel="icon" href="{{ asset('asset2026/icon.webp') }}" type="image/webp">
    @vite(['resources/css/app.css'])
    <style>
        body {
            cursor: url("{{ asset('asset2026/cursor/cursor.webp') }}") 0 0, auto;
        }

        button:hover, a:hover, li:hover {
            cursor: url("{{ asset('asset2026/cursor/pointer.webp') }}") 16 0, pointer !important;
        }

        input:hover {
            cursor: url("{{ asset('asset2026/cursor/type.webp') }}") 16 16, text !important;
        }

        .bg-dark-brown {
            background-color: #733B22;
        }

        .bg-light-brown {
            background-color: #BE8F57;
        }

        .bg-cream {
            background-color: #F0E9CF;
        }

        .action:hover {
            background-color: #A8A365 !important;
            border-color: #A8A365 !important;
            color: #ffffff !important;
        }
    </style>
</head>
<body>
    <div class="p-10 min-h-screen flex flex-col items-center justify-center border border-black gap-y-3 lg:gap-y-1">
        <img src="{{ asset('asset2026') }}/Title.webp" alt="" class="sm:w-2/3 md:w-1/2 xl:w-1/3 select-none" draggable="false">
        <div class="flex gap-x-2 lg:gap-x-3 text-xl md:text-2xl font-black text-primary select-none">
            <p>{{ $code }}</p>
            <p>{{ $title }}</p>
        </div>
        <a href="{{ route('index') }}" class="btn btn-secondary px-5 lg:px-6 rounded mt-1 lg:mt-3 bg-[#847E31] action">Back to Home</a>
    </div>
</body>
</html>
