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

    <link rel="icon" href="{{ asset('asset2025/Icon.ico') }}" type="image/x-icon">

    <style>
        html{
            overflow-x: hidden;
        }

        body {
            cursor: url("{{ asset('asset2025') }}/cursor/cursor.cur"),
                url("{{ asset('asset2025') }}/cursor/cursor.svg"),
                url("{{ asset('asset2025') }}/cursor/cursor.png"), auto;
        }

        button:hover,
        a:hover,
        li:hover {
            cursor: url("{{ asset('asset2025') }}/cursor/pointer.png"), pointer !important;
        }

        input:hover {
            cursor: url("{{ asset('asset2025') }}/cursor/type.png"), text !important;
        }

        #navbarNav {
            justify-content: center;
        }

        body {
            background-image: url("{{ asset('asset2026/home/bg.png') }}") !important;
            background-size: cover;
            background-position: center top;
            background-repeat: no-repeat;
        }

        p {
            font-family: 'Roboto';
        }

        .container-fluid {
            background-color: transparent;
        }

        .dropdown {
            margin-left: auto;
        }

        .dropDownMenu {
            z-index: 950;
            display: block;
        }

        .nav-wrapper {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-top: 32px;
            padding-top: 100px;
            padding: 0 40px;
        }

        .navbar {
            background-color: #8b181b !important;   /* Menyesuaikan VI */
            border-radius: 50px;
            height: 80px;
            margin: 0;
            margin-right: 90px;
            margin-left: 30px;
            padding: 25px 0px;
            width: 100%;
        }

        .bg-red {
            background-color: #733B22 !important; /* Menyesuaikan VI */
        }

        .container-bottom-home {
            position: absolute;
            bottom: 100px;
        }

        .bottom-web-home {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
        }
.main {
    min-height: 100vh;
}
        .dropdown-item,
        .nav-link {
            font-weight: 600;
            font-family: "Roboto";
            font-size: 16pt;
        }

        .navbar-nav {
            gap: 25px;
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

        .c-logo{
           padding: 0.5rem; 
        }

        @media (max-width: 500px){
            .c-logo{
               padding: 0.15rem; 
            }   
        }

        @media screen and (min-width: 993px) {
            :root{
                --c-h2-notif: 2.9vw;
                --c-p-notif: 1.4vw;
                --c-width-notif: 50vw;
                --c-height-notif: 35vh;
            }
        }
        
        @media screen and (min-width: 769px) and (max-width: 992px) {
            :root{
                --c-h2-notif: 3.2vw;
                --c-p-notif: 1.7vw;
                --c-width-notif: 60vw;
                --c-height-notif: 35vh;
            }
        }
        
        @media screen and (min-width: 576px) and (max-width: 768px) {
            :root{
                --c-h2-notif: 3.7vw;
                --c-p-notif: 2.2vw;

                --c-width-notif: 70vw;
                --c-height-notif: 35vh;
            }
        }
        
        @media screen and (min-width: 383px) and (max-width: 575px) {
            :root{
                --c-h2-notif: 6vw;
                --c-p-notif: 3.2vw;
    
                --c-width-notif: 90vw;
                --c-height-notif: 32vh;
            }
        }

        @media screen and (max-width: 382px) {
            :root{
                --c-h2-notif: 6vw;
                --c-p-notif: 3.7vw;
    
                --c-width-notif: 90vw;
                --c-height-notif: 32vh;
            }
        }

        @media screen and (max-width: 992px) {
            .dropdown{
                display: none;
            }
        }

        #notificationOverlay{
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

        .notif-bg{
            position: absolute;
            bottom: -90%;
            left: 0;
            z-index: 900;
            opacity: 30%;
        }

        .hide{
            display: none;
        }

        .non-hide{
            display: block;
        }

    </style>
    @yield('styles')

</head>

<body class="antialiased overflow-x-hidden">
    {{-- <x-notification-overlay/>  --}}
    <div onclick="hideNotification(this)" id="notificationOverlay" class="overflow-hidden container-notif bg-white text-center hide">
        <div id="notificationBox">
            <h2 accesskey=""class="mb-2">Batch Pendaftaran Early Bird Telah Berakhir</h2>
            <p class="mb-6">*Batch pendaftaran normal akan dibuka pada Senin, 9 Juni 2025</p>
        </div>
        <img src="{{ asset('asset2026/!header_footer/Footer.png') }}" style="width: 100%" class="notif-bg">
    </div>
    @if (Route::has('login'))
    <div class="nav-wrapper">
        <div class="logo d-flex" style="width: 40%">
            <div class="c-logo d-flex .align-items-center rounded">
                <img src="{{ asset('asset2026/Logo.png') }}" style="width: 100%">
            </div>
        </div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
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
                            <a class="nav-link" aria-current="page" href="{{ route('index') }}">HOME</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('visitor.about') }}">ABOUT US</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('visitor.competition') }}">COMPETITION</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('visitor.faq') }}">FAQ</a>
                        </li>
                        <li>
                            {{-- <a class="nav-link" href="{{ asset('asset2024/main/guidebook.pdf') }}"
                                download="Guidebook MANIAC XIV.pdf">GUIDEBOOK</a> --}}
                            <a class="nav-link" href="http://bit.ly/GuideBookMANIACXIV" target="_blank">CONTACT</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- User -->
        <div class="dropdown">
            <button class="btn btn-secondary nav-link text-center" type="button"
              data-bs-toggle="dropdown" aria-expanded="false">
                <strong >
                    {{-- <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"--}}
                    {{-- fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16"> --}}
                    {{-- <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" /> --}}
                    {{-- <path fill-rule="evenodd" --}}
                    {{-- d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" /> --}}
                    {{-- </svg>&nbsp; --}}
                    <img src="{{ asset('asset2026/User.png') }}" style="width: 90px">
                 </strong>
                                </button>
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
    </div>
        <!-- Offcanvas menu -->
        <div class="offcanvas offcanvas-start bg-red" tabindex="-1" id="offcanvasNavbar"
            aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <h4 class="offcanvas-title text-white" id="offcanvasNavbarLabel" style="font-family: 'cinzel'">MANIAC
                    XIV</h4>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <!-- Offcanvas menu links -->
                <ul class="navbar-nav">
                    <li class="nav-item offcanvas-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('index') }}">HOME</a>
                    </li>
                    <li class="nav-item offcanvas-item">
                        <a class="nav-link" href="{{ route('visitor.about') }}">ABOUT US</a>
                    </li>
                    <li class="nav-item offcanvas-item">
                        <a class="nav-link" href="{{ route('visitor.competition') }}">COMPETITION</a>
                    </li>
                    <li class="nav-item offcanvas-item">
                        <a class="nav-link" href="{{ route('visitor.faq') }}">FAQ</a>
                    </li>
                    <li>
                        {{-- <a class="nav-link text-white offcanvas-item" href="{{ asset('asset2024/main/guidebook.pdf') }}" download="Guidebook MANIAC XIII.pdf">GUIDEBOOK</a> --}}
                        <a class="nav-link" href="http://bit.ly/GuideBookMANIACXIV" target="_blank">GUIDEBOOK</a>
                    </li>
                    <li>
                        <div class="dropdown">
                            <button class="btn dropdown-toggle text-white offcanvas-item" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #7f4c42;">
                                ACCOUNT
                            </button>
                            <ul class="dropdown-menu btn-secondary">
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
                                            <a href="{{ route('register') }}" class="dropdown-item text-white">REGISTER</a>
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
    <main class="position-relative">
        @yield('content')
        <span class="d-block" style="height: 7rem;"></span>
        <img src="{{ asset('asset2026/!header_footer/Footer.png') }}" class="bottom-web-home position-absolute">
    </main>


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
            @if(session('show_early_bird_ended_announcement'))
                showStaticNotification();
            @endif
        });
    </script>
</body>
</html>