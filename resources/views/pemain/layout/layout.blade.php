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

        .bg-dark-brown {
            background-color: #733B22;
        }
        
        .bg-light-brown {
            background-color: #BE8F57;
        }
        
        .bg-cream {
            background-color: #F0E9CF;
        }

        .text-bone {
            color: #E7EADF;
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
    </style>
    @yield('cdn')
    @yield('styles')
</head>
<body class="bg-cream" data-theme="dark">
{{--  Navigation Bar  --}}
<div class="navbar bg-dark-brown max-md:px-2 md:px-10 lg:py-4 z-50 text-bone">
    <div class="flex-1 py-4">
        <div class="dropdown">
            <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" /></svg>
            </div>
            <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[20] p-2 shadow bg-light-brown rounded-md w-52 gap-2">
                <li><a href="{{ route('team.index') }}" class="{{ (Route::current()->getName() == 'team.index') ? 'bg-light-brown' : '' }}">Dashboard</a></li>
                <li><a href="{{ route('team.contest') }}" class="{{ (Route::current()->getName() == 'team.contest') ? 'bg-light-brown' : '' }}">Contest</a></li>
            </ul>
        </div>
        <a class="btn btn-ghost bg-white rounded-lg flex flex-col sm:flex-row">
            <span class="flex items-center">
                <img src="{{ asset('asset2025') }}/logo-maniac.png" alt="logo maniac" class="w-16 sm:w-16 rounded">
                <img src="{{ asset('asset2025') }}/logo-ubaya.png" alt="logo ubaya" class="w-16 sm:w-16 rounded">
            </span>
            <span class="sm:text-xl text-md font-bold text-dark-brown action">
                <span class="hidden sm:inline">| </span>MANIAC XIV
            </span>
        </a>
    </div>
    <div class="flex-none z-50">
        <ul class="menu menu-horizontal p-0 uppercase font-semibold">
            <li>
                <details>
                    <summary>
                        Menu
                    </summary>
                    <ul class="p-2 bg-light-brown rounded-t-none ">
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

<div class="flex justify-center hidden lg:flex sticky mt-8 top-4 z-40">
    <div class="hidden lg:flex lg:justify-center bg-dark-brown rounded-lg w-full max-w-7xl mx-10">
        <div class="flex justify-center items-center">
            <ul class="menu menu-horizontal gap-7">
                <li>
                    <a class="{{ (Route::current()->getName() == 'team.index') ? 'bg-light-brown' : '' }} uppercase font-bold text-base text-bone" href="{{ route('team.index') }}">
                    {{-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 3v1.5M4.5 8.25H3m18 0h-1.5M4.5 12H3m18 0h-1.5m-15 3.75H3m18 0h-1.5M8.25 19.5V21M12 3v1.5m0 15V21m3.75-18v1.5m0 15V21m-9-1.5h10.5a2.25 2.25 0 0 0 2.25-2.25V6.75a2.25 2.25 0 0 0-2.25-2.25H6.75A2.25 2.25 0 0 0 4.5 6.75v10.5a2.25 2.25 0 0 0 2.25 2.25Zm.75-12h9v9h-9v-9Z" />
                    </svg> --}}
                        Dashboard
                    </a>
                </li>
                <li>
                    <a class="{{ (Route::current()->getName() == 'team.contest') ? 'bg-light-brown' : '' }} uppercase font-bold text-base text-bone" href="{{ route('team.contest') }}">
                        {{-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25" />
                        </svg> --}}
                        Contest
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

{{--  Content  --}}
<div class="p-10 flex flex-col items-center">
    <img src="{{ asset('asset2025') }}/pendaftaran/cloud/c1.png" alt="" class="absolute hidden lg:block left-0 w-50 translate-y-[80%]" draggable="false">
    {{-- <img src="{{ asset('asset2025') }}/pendaftaran/cloud/c2.png" alt="" class="absolute hidden lg:block right-0 w-50" draggable="false"> --}}
    {{-- <img src="{{ asset('asset2025') }}/pendaftaran/cloud/c3.png" alt="" class="absolute hidden lg:block left-0 w-50" draggable="false"> --}}
    {{-- <img src="{{ asset('asset2025') }}/pendaftaran/cloud/c4.png" alt="" class="absolute hidden lg:block right-0 w-50" draggable="false"> --}}
    <img src="{{ asset('asset2025') }}/pendaftaran/cloud/c5.png" alt="" class="absolute hidden lg:block right-0 w-50 translate-y-[200%]" draggable="false">
    {{-- <img src="{{ asset('asset2025') }}/pendaftaran/cloud/c6.png" alt="" class="absolute hidden lg:block left-0 w-50" draggable="false"> --}}
    @yield('content')
    <div class="w-full pt-12 px-2">
        <p class="text-white max-md:text-sm md:text-md" id="footer">COPYRIGHT &copy; MANIAC XIV Information System | All Rights Reserved</p>
    </div>
</div>

@yield('scripts')
</body>
</html>
