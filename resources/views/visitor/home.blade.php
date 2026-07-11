@extends('visitor.welcome')

@section('styles')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap');
        @import url('https://fonts.cdnfonts.com/css/augustus');

        /* Variabel */
        @media (max-width: 575px) {
            :root {
                /* Ambil width : 420 */
                --logo-maniac: 75%;
                --win-up: 65%;
                --register-button: 40%;
                --timeline-text: 25%;
                --prizes-text: 25%;
                --joinNow-text: 25%;
                --fs-1: 0.87rem;
                --fs-ket-prizes-1: 9px;
                --fs-ket-prizes-2: 7px;
                --button: 9px;
                --button-radius: 8px;
                --button-weight: 650;
                --video-container-br: 11px;
                --video-br: 10px;
                --video-height: 130px;
            }
        }

        @media (min-width: 576px) and (max-width: 768px) {
            :root {
                /* Titik tengah : 672 */
                --logo-maniac: 75%;
                --win-up: 65%;
                --register-button: 40%;
                --timeline-text: 25%;
                --prizes-text: 25%;
                --joinNow-text: 25%;
                --register-timeline: 40%;
                --fs-1: 1.7rem;
                --fs-join-now: 24px;
                --fs-ket-prizes-1: 14px;
                --fs-ket-prizes-2: 11px;
                --button: 17px;
                --button-radius: 12px;
                --button-weight: 650;
                --video-container-br: 22px;
                --video-br: 17px;
                --video-height: 190px;
            }
        }

        @media (min-width: 769px) and (max-width: 992px) {
            :root {
                /* Titik Tengah : 880.5 */
                --logo-maniac: 65%;
                --win-up: 55%;
                --register-button: 30%;
                --timeline-text: 25%;
                --prizes-text: 25%;
                --joinNow-text: 25%;
                --register-timeline: 30%;
                --fs-1: 2.3rem;
                --fs-timeline: 29px;
                --fs-join-now: 32px;
                --fs-ket-prizes-1: 17px;
                --fs-ket-prizes-2: 14x;
                --button: 23.5px;
                --button-radius: 16px;
                --button-weight: 600;
                --video-container-br: 26px;
                --video-br: 21px;
                --video-height: 250px;
            }
        }

        @media (min-width: 993px) and (max-width: 1200px) {
            :root {
                /* Titik Tengah: 1096.5 */
                --logo-maniac: 65%;
                --win-up: 55%;
                --register-button: 30%;
                --timeline-text: 25%;
                --prizes-text: 25%;
                --joinNow-text: 25%;
                --register-timeline: 30%;
                --fs-1: 3rem;
                --fs-timeline: 37px;
                --fs-join-now: 40px;
                --fs-ket-prizes-1: 20px;
                --fs-ket-prizes-2: 17px;
                --button: 29px;
                --button-radius: 26.5px;
                --button-weight: 600;
                --video-container-br: 30px;
                --video-br: 25px;
                --video-height: 300px;
            }
        }

        @media (min-width: 1201px) {
            :root {
                /* Ambil width 1350 */
                --logo-maniac: 65%;
                --win-up: 55%;
                --register-button: 30%;
                --timeline-text: 25%;
                --prizes-text: 25%;
                --joinNow-text: 25%;
                --fs-1: 3rem;
                --fs-timeline: 44px;
                --fs-join-now: 47px;
                --fs-ket-prizes-1: 23px;
                --fs-ket-prizes-2: 20px;
                --button: 35px;
                --button-radius: 31.5px;
                --button-weight: 600;
                --video-container-br: 34px;
                --video-br: 29px;
                --video-height: 400px;
            }
        }

        /* Variabel */

        p {
            margin: 0;
            padding: 0;
        }

        .register-button{
            margin-top: 20%;
            width: var(--register-button);
        }

        .win-up{
            width: var(--win-up);
        }
        .logo-maniac {
            width: var(--logo-maniac);
        }

        .timeline-text {
            width: var(--timeline-text);
        }

        .prizes-text {
            width: var(--prizes-text);
        }

        .joinNow-text {
            width: var(--joinNow-text);
        }

        .container-page-1 {
            padding-top: 5%;
        }

        .container-page-2 {
            margin-top: 20%
        }

        .container-page-4 {
            margin-top: 6%;
            margin-bottom: 10%;
        }

        .container-page-6 {
            margin-top: 30%;
            margin-bottom: 5%;
        }

        .container-juara {
            top: 20%;
            width: 100%;
            position: relative;
        }

        /* Text */
        .win-up {
            margin: 0;
            padding: 0;
            z-index: 1;
        }

        .container-text-3 {
            margin-top: 7%;
            margin-bottom: 3%;
            font-family: Lato;
            font-weight: 600;
            text-align: center;
            color: #590212;
        }

        .container-text-3 p:nth-child(1) {
            font-size: var(--fs-ket-prizes-1);
        }

        .container-text-3 p:nth-child(2) {
            font-size: var(--fs-ket-prizes-2);
        }


        /* Text */

        /* Decoration */
        .dec-1 {
            margin: 1.7% 0 3% 0;
            width: 2.3%;
            height: 100%;
        }

        .dec-2 {
            z-index: 1;
            width: 15%;
            height: 100%;
        }

        .dec-2-1 {
            height: auto;
            position: absolute;
            right: 17%;
            top: 4%;
        }

        .dec-2-2 {
            height: auto;
            left: 17%;
            bottom: -1.3%;
            transform: rotate(3.14159rad);
        }

        .dec-3 {
            width: 22%;
        }

        .dec-3-1{
            transform: rotate(3.14159rad);
        }

        .dec-3-2 {
            margin-bottom: 5%;
        }

        .dec-3-4 {
            margin-bottom: 10%;
        }

        .dec-3-5 {
            margin-bottom: 3%;
        }

        .c-c1{
            z-index: -1;
            top: -10%;
            width: 100vw;
        }
        /* Decoration */

        /* Button */
        .register-now {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            padding: 0;
            z-index: 1;
            color: white;
            cursor: default;
        }

        /* Button */

        .container-axe-poster {
            padding-top: 4%;
        }

        /* Axe */
        .axe {
            z-index: 3;
            top: 0;
            width: 16%;
        }

        .axe-2 {
            transform: rotateY(3.142rad);
        }

        /* Axe */

        /* Poster */
        .wrap-poster {
            width: 60%;
            margin: 2%;
            padding: 2.8%;
        }

        .poster {
            width: 70%;
            z-index: 4;
        }

        /* Poster */

        /* Timeline */
        .timeline {
            width: 90%;
        }

        /* Timeline */

        /* Juara */
        .juara {
            padding-top: 2vw;
            width: 85vw;
            margin: 0;
            position: relative;
        }

        .juara-1-1 {
            margin-left: auto;
            margin-right: auto;
            display: block;
            top: 4vw;
        }

        .juara-2 {
            width: 20vw;
            position: relative;
            top: -50%;
        }

        /* Juara */

        /* USP */

        .container-usp {
            width: 25vw;
            margin-left: 1.5vw;
            margin-right: 1.5vw;
            bottom: 5%;
            position: relative;
            top: 2vw;
        }

        /* video */
        .container-video {
            width: 50%;
            height: 100%;
            padding: 2% 3.5%;
            border-bottom: 1px solid #D9D9D9;
            border-radius: var(--video-container-br);
            background-color: #B34A37;
            box-shadow: 0 4px 6px -2px #be8f57;
        }

        .iframe {
            width: 100%;
            height: var(--video-height);
            border-radius: var(--video-br);
        }
        .c-ss-container{
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 800;

            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;

            width: 30vw;
            height: 25vh;

            background-color: rgba(230, 230, 230, 0.95);
            border-radius: 1rem;
        }

        /* Pastikan container-nya relative */
        .container-poster {
            position: relative;
        }

        /* Ini kodemu yang asli, tidak ada yang diubah */
        .poster {
            width: 60%;
            z-index: 4;
        }

        /* Ini class baru untuk gambar polosan yang menimpa */
        .poster-download {
            position: absolute;
            width: 60%; /* Lebarnya wajib persis sama dengan class .poster */
            height: 100%; /* Agar tingginya menutupi seluruh gambar berbingkai */
            z-index: 10; /* Berada di paling atas */
            left: 50%;
            transform: translateX(-50%);

            /* INI KUNCINYA: Membuat gambar polosan tidak terlihat sama sekali */
            opacity: 0;
        }

        /* video */
    </style>
@endsection

@section('content')
    <!-- Jika home menerima variabel msgSession maka munculkan notif ini -->
    @if(isset($msgSession))
        <div class="c-ss-container c-hide">
            <h1>Error</h1>
            <p>{{ $msgSession }}</p>
        </div>
    @endif
    <div class="container-fluid p-0">
        <div class="container-page-1 position-relative">
            <div class="d-flex align-items-center flex-column" data-aos="fade-up">
                <img src="{{ asset('asset2026/home/Title.webp') }}" alt="Logo Maniac" class="logo-maniac z-1">
            </div>
        </div>
        <div class="container-page-2 position-relative">
            <div class="d-flex align-items-center flex-column">
                <img src="{{ asset('asset2026/home/winUp.webp') }}" class="win-up z-1">
                <div class="register-now">
                    <a class = "d-flex align-items-center flex-column"href="{{ route('register') }}"><img src="{{ asset('asset2026/home/Register Button.webp') }}" class="register-button mb-3 z-1"></a>
                </div>
            </div>
        </div>
        <div class="container-page-3 position-relative" data-aos="fade-down" data-aos-delay="50">
            <div class="container-poster d-flex justify-content-center position-relative">
                <!-- LAYER BAWAH (Visual): Ini gambar yang dilihat oleh user (Poster + Bingkai) -->
                <img src="{{ asset('asset2026/home/bingkai.webp') }}" alt="Poster Maniac" class="poster">

                <!-- LAYER ATAS (Tersembunyi): Ini gambar yang akan didownload user (Hanya Poster) -->
                <img src="{{ asset('asset2026/home/poster.webp') }}" alt="Download Poster" class="poster-download">
            </div>
        </div>
        <div class="container-page-4 position-relative" data-aos="fade-right" data-aos-delay="100">
            <div class="d-flex justify-content-center flex-column align-items-center">
                <img src="{{ asset('asset2026/home/TimelineLogo.webp') }}" class="dec-3 dec-3-2">
                <img src="{{ asset('asset2026/home/Timeline.webp') }}" alt="Timeline Maniac" class="timeline">
            </div>
        </div>
        <div class="container-page-5 position-relative" data-aos="fade-left" data-aos-delay="100">
            <div class="d-flex justify-content-center flex-column align-items-center ">
                <img src="{{ asset('asset2026/home/Prizes.webp') }}" class="prizes-text z-1">
                <div class="container-juara">
                    <div class="img-juara-1 d-flex justify-content-center align-items-center">
                        <img src="{{ asset('asset2026/home/prizepool.webp') }}" alt="Juara I" class="juara juara-1-1">
                    </div>
                </div>
                {{-- <div class="container-text-3 d-flex justify-content-center flex-column ">
                    <p>*Terdiri atas 3 orang dari SMA/SMK yang sama</p>
                    <p>*&#41;USP berlaku jika masuk Program Studi Teknik Informatika Program Digital Media Technology</p>
                </div> --}}
            </div>
        </div>

        <div class="container-page-6 position-relative">
            <div class="container-text-iframe d-flex justify-content-center flex-column align-items-center ">
                <img src="{{ asset('asset2026/home/Join Now.webp') }}" class="dec-3 dec-3-5">
                <div class="container-video d-flex justify-content-center align-items-center z-1" data-aos="zoom-in"
                    data-aos-delay="50">
                    <iframe src="https://www.youtube.com/embed/rDMyy3Ln-oA?si=3To5aAn0mAVfwgqw" frameborder="0"
                        class="iframe d-flex align-items-center justify-content-center"></iframe>
                </div>
            </div>
        </div>
    </div>
@endsection
