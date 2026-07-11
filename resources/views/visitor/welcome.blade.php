<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>MANIAC XV</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    {{-- font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- aos --}}
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/font.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">

    <link rel="icon" href="{{ asset('asset2026/icon.webp') }}" type="image/webp">

    <style>
        html {
            overflow-x: hidden;
        }

        body {
            cursor: url("{{ asset('asset2026/cursor/cursor.webp') }}") 0 0, auto;
        }

        button:hover,
        a:hover,
        li:hover {
            cursor: url("{{ asset('asset2026/cursor/pointer.webp') }}") 16 0, pointer !important;
        }

        input:hover {
            cursor: url("{{ asset('asset2026/cursor/type.webp') }}") 16 16, text !important;
        }

        #navbarNav {
            justify-content: center;
        }

        body {
            background-image: url("{{ asset('asset2026/home/bg.webp') }}") !important;
            background-size: cover;
            background-position: center top;
            background-repeat: no-repeat;
            min-height: 100vh;
        }

        .navbar-nav .nav-item .active-link {
            background-color: white;
            color: #8b181b !important;
            border-radius: 20px;
            padding: 6px 30px;
        }

        p {
            font-family: 'Roboto';
        }

        .container-fluid {
            background-color: transparent;
        }

        .dropDownMenu {
            z-index: 950;
            display: block;
        }

        .nav-wrapper {
            display: flex;
            align-items: center;
            gap: clamp(10px, 3vw, 50px);
            padding: 15px 20px;
        }

        .navbar {
            background-color: #8b181b !important;
            width: 70%;
        }

        .navbar-collapse.ms-auto {
            margin-left: 0 !important;
            margin: 0 auto !important;
            width: 100%;
        }

        .bg-red {
            background-color: #8b181b !important;
        }

        .container-bottom-home {
            position: absolute;
            bottom: 100px;
        }

        .bottom-web-home {
            position: relative;
            bottom: 0;
            left: 0;
            width: 100%;
            z-index: -1;
            height: auto;
        }

        .dropdown-item,
        .nav-link {
            font-weight: 600;
            font-size: 18px;
            font-family: "Roboto";
        }

        .navbar-nav {
            width: 100%;
            justify-content: space-evenly !important;
        }

        .icon {
            width: 20px;
            height: auto;
        }

        .sosmedLink {
            text-decoration: none;
            font-size: 1.05rem;
            /*color: #E7EADF;*/
            /*transition: all 0.3s ease-in-out;*/
        }

        .sosmedLink:hover {
            font-weight: bolder;
        }

        .container-logo {
            width: 100px;
            height: auto;
            background-color: rgba(210, 210, 210, 0.9);
            border-radius: 20px;
        }

        .c-logo {
            padding: 0.5rem;
        }

        @media (max-width: 500px) {
            :root {
                --logo: 100%;
            }

            .c-logo {
                padding: 0.15rem;
            }

            .dropdown {
                display: none;
            }
        }

        @media screen and (min-width: 993px) {
            :root {
                --logo: 110%;
                --c-h2-notif: 2.9vw;
                --c-p-notif: 1.4vw;
                --c-width-notif: 50vw;
                --c-height-notif: 35vh;
            }
        }

        @media screen and (min-width: 769px) and (max-width: 992px) {
            :root {
                --logo: 100%;
                --c-h2-notif: 3.2vw;
                --c-p-notif: 1.7vw;
                --c-width-notif: 60vw;
                --c-height-notif: 35vh;
            }

            .dropdown {
                display: none;
            }
        }

        @media screen and (min-width: 576px) and (max-width: 768px) {
            :root {
                --logo: 100%;
                --c-h2-notif: 3.7vw;
                --c-p-notif: 2.2vw;

                --c-width-notif: 70vw;
                --c-height-notif: 35vh;
            }

            .dropdown {
                display: none;
            }
        }

        @media screen and (min-width: 383px) and (max-width: 575px) {
            :root {
                --logo: 100%;
                --c-h2-notif: 6vw;
                --c-p-notif: 3.2vw;

                --c-width-notif: 90vw;
                --c-height-notif: 32vh;
            }

            .dropdown {
                display: none;
            }
        }

        @media screen and (max-width: 382px) {
            :root {
                --logo: 100%;
                --c-h2-notif: 6vw;
                --c-p-notif: 3.7vw;

                --c-width-notif: 90vw;
                --c-height-notif: 32vh;
            }

            .dropdown {
                display: none;
            }
        }

        .logo-header {
            width: var(--logo);
        }

        #notificationOverlay {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 899;

            width: var(--c-width-notif);
            height: var(--c-height-notif);
            border-radius: 20px;
        }

        #notificationBox {
            position: relative;
            z-index: 999;

            padding: 0 9%;
            width: 100%;
            height: 100%;

            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        #notificationBox h2 {
            padding-bottom: 20px;
            font-family: dalek;
            color: #733B22;
            font-size: var(--c-h2-notif);
        }

        #notificationBox p {
            font-size: var(--c-p-notif);
            font-weight: bold;
            color: black;
        }

        .notif-bg {
            position: absolute;
            bottom: -90%;
            left: 0;
            z-index: 900;
            opacity: 30%;
        }

        .hide {
            display: none;
        }

        .non-hide {
            display: block;
        }

        @media screen and (min-width: 992px) {

            /* 1. Membagi ruang antara Logo, Kapsul Merah, dan Ikon Profile */
            .nav-wrapper {
                justify-content: space-between !important;
            }

            /* 2. Menghapus dorongan bawaan agar posisinya seimbang */
            .dropdown.ms-auto {
                margin-left: 0 !important;
            }

            /* 3. Melebarkan kapsul merah dan memberi jarak lega di ujungnya */
            .navbar {
                width: 65% !important;
                /* Bisa kamu naik-turunkan sesuai selera (misal 60% atau 70%) */
                padding: 8px 3rem !important;
            }
    </style>
    @yield('styles')

</head>

<body class="antialiased overflow-x-hidden">
    {{-- <x-notification-overlay/>  --}}
    <div onclick="hideNotification(this)" id="notificationOverlay"
        class="overflow-hidden container-notif bg-white text-center hide">
        <div id="notificationBox">
            <h2 accesskey=""class="mb-2">Batch Pendaftaran Early Bird Telah Berakhir</h2>
            <p class="mb-6">*Batch pendaftaran normal akan dibuka pada Senin, 11 Juni 2026</p>
        </div>
        <img src="{{ asset('asset2026/!header_footer/Footer.webp') }}" style="width: 100%" class="notif-bg">
    </div>
    @if (Route::has('login'))
        <div class="nav-wrapper d-flex align-items-center">

            <!-- Logo -->
            <div class="logo d-flex" style="width: 270px">
                <div class="c-logo d-flex .align-items-center rounded">
                    <img src="{{ asset('asset2026/!header_footer/Logo.webp') }}" class="logo-header">
                </div>
            </div>

            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-light rounded-5">
                <div class="container-fluid d-flex justify-content-end">
                    <!-- Toggle button for small screens -->
                    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-list text-white" style="transform: scale(1.2)" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5" />
                        </svg>
                    </button>

                    <!-- Navbar links -->
                    <div class="collapse navbar-collapse ms-auto" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('index') ? 'active-link' : '' }}"
                                    aria-current="page" href="{{ route('index') }}">HOME</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('visitor.about') ? 'active-link' : '' }}"
                                    href="{{ route('visitor.about') }}">ABOUT US</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('visitor.competition') ? 'active-link' : '' }}"
                                    href="{{ route('visitor.competition') }}">COMPETITION</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('visitor.faq') ? 'active-link' : '' }}"
                                    href="{{ route('visitor.faq') }}">FAQ</a>
                            </li>
                            <li>
                                {{-- <a class="nav-link" href="{{ asset('asset2024/main/guidebook.pdf') }}"
                                download="Guidebook MANIAC XIV.pdf">GUIDEBOOK</a> --}}
                                <a class="nav-link" href="#contact">CONTACT</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- User -->
            <div class="dropdown ms-auto">
                <button class="btn nav-link text-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <strong>
                        {{-- <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" --}}
                        {{-- fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16"> --}}
                        {{-- <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" /> --}}
                        {{-- <path fill-rule="evenodd" --}}
                        {{-- d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" /> --}}
                        {{-- </svg>&nbsp; --}}
                        <img src="{{ asset('asset2026/User.webp') }}" style="width: 70px">
                    </strong>
                </button>
                <ul class="dropdown-menu bg-red">
                    @auth
                        @php
                            $endpoint = '';
                            switch (\Illuminate\Support\Facades\Auth::user()->role) {
                                case 'participant':
                                    $endpoint = '/team';
                                    break;
                                case 'acara':
                                    $endpoint = '/acara';
                                    break;
                                case 'si':
                                    $endpoint = '/si';
                                    break;
                                case 'supersi':
                                    $endpoint = '/super-si';
                                    break;
                                case 'admin':
                                    $endpoint = '/admin';
                                    break;
                                case 'judge':
                                    $endpoint = '/judge';
                                    break;
                                default:
                                    $endpoint = '/penpos';
                                    break;
                            }
                        @endphp
                        <li>
                            <a href="{{ url($endpoint) }}" class="dropdown-item text-white">Dashboard</a>
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" id="logout">
                                @csrf
                                <button class="btn-logout dropdown-item text-white" type="submit">Logout</button>
                            </form>
                        </li>
                    @else
                        <li>
                            <a href="{{ route('login') }}" class="dropdown-item text-white">LOGIN</a>
                        </li>
                        @if (Route::has('register'))
                            <li>
                                <a href="{{ route('register') }}" class="dropdown-item text-white">REGISTER</a>
                            </li>
                        @endif
                    @endauth
                </ul>
            </div>
        </div>

        <!-- Offcanvas menu -->
        <div class="offcanvas offcanvas-start bg-red" tabindex="-1" id="offcanvasNavbar"
            aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <h4 class="offcanvas-title text-white" id="offcanvasNavbarLabel" style="font-family: 'cinzel'">MANIAC
                    XV</h4>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <!-- Offcanvas menu links -->
                <ul class="navbar-nav">
                    <li class="nav-item offcanvas-item">
                        <a class="nav-link d-flex align-items-center gap-2 px-2 mb-1 {{ request()->routeIs('index') ? 'active-link' : '' }}"
                            aria-current="page" href="{{ route('index') }}">HOME</a>
                    </li>
                    <li class="nav-item offcanvas-item">
                        <a class="nav-link d-flex align-items-center gap-2 px-2 mb-1 {{ request()->routeIs('visitor.about') ? 'active-link' : '' }}"
                            href="{{ route('visitor.about') }}">ABOUT US</a>
                    </li>
                    <li class="nav-item offcanvas-item">
                        <a class="nav-link d-flex align-items-center gap-2 px-2 mb-1 {{ request()->routeIs('visitor.competition') ? 'active-link' : '' }}"
                            href="{{ route('visitor.competition') }}">COMPETITION</a>
                    </li>
                    <li class="nav-item offcanvas-item">
                        <a class="nav-link d-flex align-items-center gap-2 px-2 mb-1 {{ request()->routeIs('visitor.faq') ? 'active-link' : '' }}"
                            href="{{ route('visitor.faq') }}">FAQ</a>
                    </li>
                    <li class="nav-item offcanvas-item">
                        {{-- <a class="nav-link text-white offcanvas-item" href="{{ asset('asset2024/main/guidebook.pdf') }}" download="Guidebook MANIAC XIII.pdf">GUIDEBOOK</a> --}}
                        <a class="nav-link d-flex align-items-center gap-2 px-2 mb-1" href="#contact">CONTACT</a>
                    </li>
                    <li>
                        <hr class="text-white">
                        <div class="d-flex align-items-center gap-2 px-2">
                            <img src="{{ asset('asset2026/User.webp') }}"
                                style="width: 60px; border: 2px solid white; border-radius: 50%;">
                        </div>

                        @auth
                            <a href="{{ url($endpoint) }}"
                                class="nav-link text-white d-flex align-items-center gap-2 px-2">Dashboard</a>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button
                                    class="nav-link text-white w-100 d-flex align-items-center gap-2 px-2">Logout</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}"
                                class="nav-link text-white d-flex align-items-center gap-2 px-2 mt-3 mb-2 {{ request()->routeIs('login') ? 'active-link' : '' }}">LOGIN</a>
                            <a href="{{ route('register') }}"
                                class="nav-link text-white d-flex align-items-center gap-2 px-2 {{ request()->routeIs('register') ? 'active-link' : '' }}">REGISTER</a>
                        @endauth
                    </li>
                    <li>
                        <div class="dropdown">
                            <ul class="dropdown-menu">
                                @auth
                                    @php
                                        $endpoint = '';
                                        switch (\Illuminate\Support\Facades\Auth::user()->role) {
                                            case 'participant':
                                                $endpoint = '/team';
                                                break;
                                            case 'acara':
                                                $endpoint = '/acara';
                                                break;
                                            case 'si':
                                                $endpoint = '/si';
                                                break;
                                            case 'supersi':
                                                $endpoint = '/super-si';
                                                break;
                                            case 'admin':
                                                $endpoint = '/admin';
                                                break;
                                            case 'judge':
                                                $endpoint = '/judge';
                                                break;
                                            default:
                                                $endpoint = '/penpos';
                                                break;
                                        }
                                    @endphp
                                    <li>
                                        <a href="{{ url($endpoint) }}"
                                            style="font-size: 1rem !important; letter-spacing: 1px !important;"
                                            class="dropdown-item text-white">Dashboard</a>
                                    </li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST" id="logout">
                                            @csrf
                                            <button class="btn-logout dropdown-item text-white"
                                                style="font-size: 1rem !important; letter-spacing: 1px !important;"
                                                type="submit">Logout</button>
                                        </form>
                                    </li>
                                @else
                                    <li>
                                        <a href="{{ route('login') }}" class="dropdown-item text-white">LOGIN</a>
                                    </li>
                                    @if (Route::has('register'))
                                        <li>
                                            <a href="{{ route('register') }}"
                                                class="dropdown-item text-white">REGISTER</a>
                                        </li>
                                    @endif
                                @endauth
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    @endif
    <main class="position-relative p-0 m-0 w-100">
        @yield('content')
        <span class="d-block" style="height: 7rem;"></span>
        <img src="{{ asset('asset2026/!header_footer/Footer.webp') }}" class="bottom-web-home">
    </main>

    <footer id="contact" class="w-100 bg-red pt-2">
        <div class="container-fluid px-4 py-4">
            <div class="row">
                <div class="col-lg-6 col-sm-12 pe-3 pb-5">
                    <h3 class="text-white d-block" style="font-family: 'cinzel';">MANIAC XV</h3>
                    <p class="text-white text-justify"><strong>MANIAC (Multimedia and Interactive Art Competition)
                        </strong> merupakan lomba berbasis multimedia untuk anak SMA/K sederajat yang mencakup
                        Penyisihan (online), Semifinal (Rally Games & Game Besar), dan Final (presentasi). Materi yang
                        dilombakan adalah mengenai User Interface dan User Experience. MANIAC diselenggarakan oleh
                        Program Studi Teknik Informatika Program Digital Media Technology Universitas Surabaya.</p>
                    <img src="{{ asset('asset2026/LogoUbaya.webp') }}" width="150px" height="auto"
                        alt="logo-ubaya" class="pt-3">
                    <img src="{{ asset('asset2026/LogoManiac.webp') }}" width="150px" height="auto"
                        alt="logo-maniac" class="pt-3">
                </div>
                <div class="col-lg-6 ps-lg-5 pt-sm-2">
                    <h5 class="text-white"><strong>SOCIAL MEDIA</strong></h5>
                    <div class="grid gap-4">
                        <div class="text-white d-flex align-items-center">
                            <img class="icon" src="{{ asset('asset2026/!header_footer/socials_ig.webp') }}" alt="Instagram">
                            <a class="mb-0 sosmedLink text-white" href="https://www.instagram.com/maniac_ubaya?" target="_blank" rel="noopener">
                                &nbsp;@maniac_ubaya
                            </a>
                        </div>
                        <div class="mt-2 text-white d-flex align-items-center">
                            <img class="icon" src="{{ asset('asset2026/!header_footer/socials_tt.webp') }}"
                                alt="TikTok">
                            <a class="mb-0 sosmedLink text-white" href="https://www.tiktok.com/@maniac_ubaya" target="_blank" rel="noopener">
                                &nbsp;@maniac_ubaya
                            </a>
                        </div>
                        <div class="mt-2 text-white d-flex align-items-center">
                            <img class="icon" src="{{ asset('asset2026/!header_footer/socials_yt.webp') }}"
                                alt="YouTube">
                            <a class="mb-0 sosmedLink text-white" href="https://www.youtube.com/@maniacubaya9585" target="_blank" rel="noopener">
                                &nbsp;@maniac_ubaya
                            </a>
                        </div>
                        <br><br><br>
                        <h5 class="text-white"><strong>CONTACT US</strong></h5>
                        <div class="d-flex flex-column">
                            <a class="text-white pb-2 sosmedLink" href="https://line.me/R/ti/p/%40994nxsfr"
                                target="_blank" rel="noopener">
                                <img class="icon" src="{{ asset('asset2026/!header_footer/socials_line.webp') }}" alt="line">
                                @994nxsfr
                            </a>
                            <a class="text-white pb-2 sosmedLink" href="mailto:maniac.ubayaa@gmail.com"
                                target="_blank" rel="noopener">
                                <img class="icon" src="{{ asset('asset2026/!header_footer/socials_gmail.webp') }}" alt="email">
                                maniac.ubayaa@gmail.com
                            </a>
                            <a class="text-white pb-2 sosmedLink" href="https://wa.me/+6282229088089" target="_blank"
                                rel="noopener" style="font-size: 1rem;">
                                <img class="icon" src="{{ asset('asset2026/!header_footer/socials_wa.webp') }}" alt="whatsapp">
                                082229088089 (Jovanka)
                            </a>
                            <a class="text-white pb-2 sosmedLink" href="https://wa.me/+6282232958165" target="_blank"
                                rel="noopener" style="font-size: 1rem;">
                                <img class="icon" src="{{ asset('asset2026/!header_footer/socials_wa.webp') }}" alt="whatsapp">
                                082232958165 (Nadya)
                            </a>
                        </div>
                    </div>
                </div>
                <br>
                <br>
                <p class="text-white text-start pe-5 pb-2 pt-5">COPYRIGHT &copy; MANIAC XV Information System, All
                    Rights Reserved</p>
            </div>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    @yield('script')
    <script>
        // TEMPORARY
        // Mengambil object dengan id notificationOverlay yang mana adalah container keseluruhan notif bahwa pendaftaran tutup sementara
        const notificationOverlay = document.getElementById('notificationOverlay');

        // Menampilkan notif
        // Ini adalah bentuk arrow function yang unik di javascript
        const showStaticNotification = () => {
            // Mengganti class object notificationOverlay dengan class baru yang salah satunya berisi perintah non-hide yang berisi display block
            notificationOverlay.setAttribute("class", "overflow-hidden container-notif bg-white text-center non-hide")

            // Membuat timer hitung mundur, untuk menjalankan function Menyembunyikan notif
            setTimeout(() => {
                hideNotification();
            }, 5000);
        }

        // Menyembunyikan notif
        // Jika sudah mencapai 5 detik maka objek dengan class notificationOverlay akan di sembunyikan dengan diberikan class hide
        // yang berisi perintah display : none
        const hideNotification = () => {
            notificationOverlay.setAttribute("class", "overflow-hidden container-notif bg-white text-center hide")
        }

        notificationOverlay.addEventListener('click', function(event) {
            if (event.target === notificationOverlay) {
                hideNotification();
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            @if (session('show_early_bird_ended_announcement'))
                showStaticNotification();
            @endif
        });
    </script>
</body>

</html>
