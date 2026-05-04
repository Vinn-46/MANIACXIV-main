<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'Dashboard' }}</title>
    <link rel="icon" href="{{ asset('asset2025/Icon.ico') }}" type="image/x-icon">
    @vite('resources/css/app.css')
    <style>
        * {
            scroll-behavior: smooth;
        }
        
        body {
            background-image: url("{{ asset('asset2026/pendaftaran/bg.png') }}") !important;
            background-size: cover;
            background-position: center top;
            background-repeat: no-repeat;
            min-height: 100vh;
        }

        body {
            cursor: url("{{ asset('asset2024') }}/cursor/CURSOR.cur"),
                    url("{{ asset('asset2024') }}/cursor/CURSOR.svg"),
                    url("{{ asset('asset2024') }}/cursor/CURSOR.png"), auto;
        }

        button:hover, a:hover, li:hover {
            cursor: url("{{ asset('asset2024') }}/cursor/shield.svg"),
                    url("{{ asset('asset2024') }}/cursor/shield.png"), pointer !important;
        }

        input:hover {
            cursor: url("{{ asset('asset2024') }}/cursor/sword.svg"),
                    url("{{ asset('asset2024') }}/cursor/sword.png"), text !important;
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

        .bg-dark-red {
            background-color: #8b181b;
        }
        
        .bg-white {
            background-color: #ffffff;
        }

        .text-bone {
            color: #ffffff;
        }

        .text-dark-brown {
            color: #733B22;
        }

        .text-light-brown {
            color: #BE8F57;
        }

        .action:hover {
            color:#E7EADF !important;
        }

        .bottom-web-home {
            width: 100%;
            position: relative;
        }
        
        .icon {
            width: 36px;
            height: 36px;
        }
        
        .nav{
            padding: 15px 30px;
        }

        .text-menu{
            padding: var(--menu-padding);
            font-size: var(--menu);
        }

        .logo{
            padding: 15px 20px;
            width: var(--logo);
        }
        @media (max-width: 500px){
            :root{
                --logo: 100px;
                --menu: 12px;
                --menu-padding: 10px 15px;
            }
            .nav{
                display: none;
            }
        }

        @media screen and (min-width: 993px) {
            :root{
                --logo: 270px;
                --menu: 14px;
                --menu-padding: 20px 30px;
            }
        }
        
        @media screen and (min-width: 769px) and (max-width: 992px) {
            :root{
                --logo: 270px;
                --menu: 14px;
                --menu-padding: 17px 23px;
            }
            .nav {
                display: none !important;
            }
        }
        
        @media screen and (min-width: 576px) and (max-width: 768px) {
            :root{
                --logo: 240px;
                --menu: 14px;
                --menu-padding: 15px 20px;
            }
            .nav{
                display: none;
            }
        }
        
        @media screen and (min-width: 383px) and (max-width: 575px) {
            :root{
                --logo: 200px;
                --menu: 10px;
                --menu-padding: 10px 15px;
            }
            .nav{
                display: none;
            }
        }

        @media screen and (max-width: 382px) {
            :root{
                --logo: 270px;
                --menu: 10px;
                --menu-padding: 7px 12px;
            }
            .nav{
                display: none;
            }
        }
        .nav a {
            padding: 6px 25px;
            border-radius: 20px;
            display: inline-block;
        }
        .active-link {
            background-color: white;
            color: #8b181b !important;
        }

        details summary {
            background-color: #8b181b;
            color: white;
            transition: 0.2s ease;
        }

        details summary:hover {
            background-color: #690004 !important; /* sedikit beda biar ada feedback */
        }

        details[open] summary {
            background-color: #8b181b !important;
            color: white !important;
        }
        .nav a {
            padding: 6px 25px;
            border-radius: 20px;
            display: inline-block;
            transition: 0.2s ease;
        }

        .nav a:not(.active-link):hover  {
            color: #ffe600 !important; /* kuning/brown */
        }
        .btn-ghost{
            color: #8b181b;
        }
    </style>
    @yield('cdn')
    @yield('styles')
</head>
<body class="bg-white" data-theme="dark">
{{--  Navigation Bar  --}}
<div class="navbar justify-between md:px-10 lg:py-4 z-50 text-bone">
    <div >
        <div class="dropdown font-bold">
            <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" /></svg>
            </div>
            <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[20] p-2 shadow bg-dark-red rounded-md w-52 gap-2">
                <li><a href="{{ route('team.index') }}" class="{{ (Route::current()->getName() == 'team.index') ? 'bg-light-brown' : '' }}">DASHBOARD</a></li>
                <li><a href="{{ route('team.contest') }}" class="{{ (Route::current()->getName() == 'team.contest') ? 'bg-light-brown' : '' }}">CONTEST</a></li>
            </ul>
        </div>
        <a class="bg-transparent rounded-lg flex">
            <span class="flex items-center">
                <img src="{{ asset('asset2026/!header_footer/Logo.png') }}" alt="logo maniac" class="logo">
            </span>
        </a>
    </div>
    <div class="nav bg-dark-red flex justify-center rounded-full">
        <ul class="navbar-nav flex gap-3 font-bold">
                <li class="nav-item">
                    <a href="{{ route('team.index') }}" class="{{ (Route::current()->getName() == 'team.index') ? 'active-link' : '' }}">DASHBOARD</a>
                </li>
                <li class="nav-item">
                    <li><a href="{{ route('team.contest') }}" class="{{ (Route::current()->getName() == 'team.contest') ? 'active-link' : '' }}">CONTEST</a></li>
                </li>
        </ul>
    </div>
    <div class="flex-none z-50">
        <ul class="menu menu-horizontal p-0 uppercase font-semibold">
            <li>
                <details>
                    <summary class="text-menu bg-dark-red rounded-full">
                        Menu
                    </summary>
                    <ul class="p-2 bg-dark-red rounded-t-none bg-light-brown right-0">
                        <li>
                            <a href="{{ route('index') }}">
                                Home
                            </a>
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit">
                                    LOGOUT
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
<div class="p-10 flex flex-col items-center">
    {{-- <img src="{{ asset('asset2025') }}/pendaftaran/cloud/c1.png" alt="" class="absolute hidden lg:block left-0 w-50 translate-y-[80%]" draggable="false"> --}}
    {{-- <img src="{{ asset('asset2025') }}/pendaftaran/cloud/c2.png" alt="" class="absolute hidden lg:block right-0 w-50" draggable="false"> --}}
    {{-- <img src="{{ asset('asset2025') }}/pendaftaran/cloud/c3.png" alt="" class="absolute hidden lg:block left-0 w-50" draggable="false"> --}}
    {{-- <img src="{{ asset('asset2025') }}/pendaftaran/cloud/c4.png" alt="" class="absolute hidden lg:block right-0 w-50" draggable="false"> --}}
    {{-- <img src="{{ asset('asset2025') }}/pendaftaran/cloud/c5.png" alt="" class="absolute hidden lg:block right-0 w-50 translate-y-[200%]" draggable="false">--}}
    {{-- <img src="{{ asset('asset2025') }}/pendaftaran/cloud/c6.png" alt="" class="absolute hidden lg:block left-0 w-50" draggable="false"> --}}
    @yield('content')
   
</div>

@yield('scripts')
<div class="relative w-full">
    <img src="{{ asset('asset2026/!header_footer/Footer.png') }}" class="w-full">
    <div class="absolute bottom-0 left-0 w-full text-center pb-6 md:pb-16">
        <p class="text-white" style="font-size: clamp(10px, 1.8vw, 14px)">
            &copy; Developed by MANIAC XIV commitee <br> <span class="font-bold">Social Media</span>
        </p>
        <div class="flex justify-center items-center gap-7 mt-4">
    
            <a href="https://www.instagram.com/maniac_ubaya?" target="_blank" rel="noopener"><img src="{{ asset('asset2024/footer/IG.png') }}" class="icon" alt="Instagram"> </a>

            <a href="https://line.me/R/ti/p/%40994nxsfr" target="_blank" rel="noopener"><img src="{{ asset('asset2024/footer/line.png') }}" class="icon" alt="Line"></a>

            <a href="mailto:maniac.ubayaa@gmail.com" target="_blank" rel="noopener"><img src="{{ asset('asset2024/footer/email.png') }}" class="icon" alt="Email"></a>

            <a href="https://www.tiktok.com/@maniac_ubaya" target="_blank" rel="noopener"><img src="{{ asset('asset2025/pendaftaran/icon-tiktok.png') }}" class="icon" alt="TikTok"></a>
        </div>
    </div>
</div>
</body>
</html>
