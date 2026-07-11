<!doctype html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Peserta | {{ $title ?? 'Pembayaran' }}</title>

    <link rel="icon" href="{{ asset('asset2026/icon.webp') }}" type="image/x-icon">
    @vite('resources/css/app.css')
    <style>
        * {
            scroll-behavior: smooth;
        }

        body {
            cursor: url("{{ asset('asset2026/cursor/cursor.webp') }}"), auto;
            background: url("{{ asset('asset2026/pendaftaran/background.webp') }}") no-repeat center;
            background-size: cover;
        }

        button:hover, a:hover, li:hover {
            cursor: url("{{ asset('asset2026/cursor/pointer.webp') }}"), pointer !important;
        }

        input:hover {
            cursor: url("{{ asset('asset2026/cursor/type.webp') }}"), text !important;
        }

        body::-webkit-scrollbar {
            width: 0.5em;
        }

        body::-webkit-scrollbar-track {
            box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
            background-color: oklch(var(--b3));
            width: 1px;
        }

        body::-webkit-scrollbar-thumb {
            background-color: oklch(var(--s));
            outline: 1px solid slategrey;
            border-radius: 0.8rem;
        }

        .bottom-web-home {
            position: absolute;
            width: 100vw;
            z-index: 0;
            bottom: 0;
        }

        .c-z-1{
            position: relative;
            z-index: 1;
        }
    </style>
    @yield('cdn')
    @yield('styles')
</head>
<body class="min-h-screen relative">
{{--  Navigation Bar  --}}
<div class="navbar flex justify-between bg-[#8B181B] px-4 mb-2 c-z-1 rounded-br-xl rounded-bl-xl ">
    <div>
        <a class="btn btn-ghost text-2xl max-w-full inline-flex items-center">
            <img class="max-w-full max-h-full object-contain" src="{{ asset('asset2026/Logo.webp') }}" alt="Home" />
        </a>
    </div>
    <div class="flex-none z-50 text-white">
        <ul class="menu menu-horizontal px-6">
            <li>
                <details>
                    <summary>
                        Menu
                    </summary>
                    <ul class="p-2 rounded-t-none bg-[#8B181B]" >
                        <li>
                            <a href="{{ route('index') }}">
                                Home
                            </a>
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit">
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </details>
            </li>
        </ul>
    </div>
</div>

{{--  Content  --}}
<div class="p-10 mt-7 flex flex-col items-center c-z-1">
    <div class="card rounded-lg shadow-md data">
        <h1 class="text-2xl bg-[#8B181B] p-5 font-black rounded-t-lg text-center text-white ">{{ $heading ?? "Verifikasi Bukti Pembayaran" }}</h1>
        <div class="card-body bg-[#FBF5E5] rounded-b-lg">
            <div class="grid grid-cols-1 md:grid-cols-3 place-content-center gap-7 md:gap-12">
                <div class="flex gap-3 items-center">
                    <div
                        class="text-lg flex justify-content-center items-center py-2 px-5 rounded bg-[#847E31] text-primary-content">
                        1
                    </div>
                    <div class="flex flex-col">
                        <p class="font-semibold">Upload</p>
                        <p class="text-info-content font-medium text-sm">Upload Bukti Pembayaran</p>
                    </div>
                </div>
                <div class="flex gap-3 items-center">
                    <div
                        class="text-lg flex justify-content-center items-center py-2 px-5 rounded {{ isset($step2) ? "bg-[#847E31]" : "bg-[#8C8C8C]" }} text-primary-content"
                    >
                        2
                    </div>
                    <div class="flex flex-col">
                        <p class="font-semibold">Proses Verifikasi</p>
                        <p class="text-info-content font-medium text-sm">Bukti Pembayaran Sedang Diverifikasi</p>
                    </div>
                </div>
                <div class="flex gap-3 items-center">
                    <div
                        class="text-lg flex justify-content-center items-center py-2 px-5 rounded {{ isset($step3) ? "bg-[#847E31]" : "bg-[#8C8C8C]" }} text-primary-content"
                    >
                        3
                    </div>
                    <div class="flex flex-col">
                        <p class="font-semibold">Selesai</p>
                        <p class="text-info-content font-medium text-sm">Tim Resmi Terdaftar</p>
                    </div>
                </div>
            </div>
{{--            <p class="pb-3 sm:pb-0 break-words">--}}
{{--                Anda dapat melihat <strong>Available Contest</strong>, <strong>Upcoming Contest</strong>, and <strong>Finished Contest</strong> di sini.--}}
{{--            </p>--}}
{{--            <div role="alert" class="alert alert-success rounded-md py-2">--}}
{{--                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-info shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>--}}
{{--                <span>Mohon lakukan refresh page untuk update data contest.</span>--}}
{{--            </div>--}}
            @yield('content')
        </div>
    </div>
    <div class="w-full pt-12 px-2">
        <p class="text-white text-md" id="footer">COPYRIGHT &copy; MANIAC XV Information System, All rights Reserved</p>
    </div>
</div>
<span class="d-block" style="height: 7rem;"></span>



@yield('scripts')
</body>
</html>
