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
                --fs-1: 0.87rem;
                --fs-timeline: 9.5px;
                --fs-win-up: 9.5px;
                --fs-prizes: 10.4px;
                --fs-join-now: 10.3px;
                --fs-ket-prizes-1: 9px;
                --fs-ket-prizes-2: 7px;
                --button: 9px;
                --button-radius: 8px;
                --button-weight: 650;
                --video-container-br: 11px;
                --video-br: 10px;
                --video-height: 130px;
            }

            h1.text-timeline,
            h1.text-join-now,
            h1.text-prizes {
                text-shadow: -1px 0.5px  #be8f57;
            }
        }

        @media (min-width: 576px) and (max-width: 768px) {
            :root {
                /* Titik tengah : 672 */
                --logo-maniac: 75%;
                --fs-1: 1.7rem;
                --fs-timeline: 22px;
                --fs-win-up: 22px;
                --fs-prizes: 24px;
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

            h1.text-timeline,
            h1.text-join-now,
            h1.text-prizes {
                text-shadow: -2px 1px  #be8f57;
            }
        }

        @media (min-width: 769px) and (max-width: 992px) {
            :root {
                /* Titik Tengah : 880.5 */
                --logo-maniac: 65%;
                --fs-1: 2.3rem;
                --fs-timeline: 29px;
                --fs-win-up: 29px;
                --fs-prizes: 33px;
                --fs-join-now: 32px;
                --fs-ket-prizes-1: 17px;
                --fs-ket-prizes-2: 14px;
                --button: 23.5px;
                --button-radius: 16px;
                --button-weight: 600;
                --video-container-br: 26px;
                --video-br: 21px;
                --video-height: 250px;
            }

            h1.text-timeline,
            h1.text-join-now,
            h1.text-prizes {
                text-shadow: -2px 1px  #be8f57;
            }
        }

        @media (min-width: 993px) and (max-width: 1200px) {
            :root {
                /* Titik Tengah: 1096.5 */
                --logo-maniac: 85%;
                --fs-1: 3rem;
                --fs-timeline: 37px;
                --fs-win-up: 37px;
                --fs-prizes: 41px;
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

            h1.text-timeline,
            h1.text-join-now,
            h1.text-prizes {
                text-shadow: -3px 2px  #be8f57;
            }
        }

        @media (min-width: 1201px) {
            :root {
                /* Ambil width 1350 */
                --logo-maniac: 85%;
                --fs-1: 3rem;
                --fs-timeline: 44px;
                --fs-win-up: 44px;
                --fs-prizes: 48px;
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

            h1.text-timeline,
            h1.text-join-now,
            h1.text-prizes {
                text-shadow: -3px 2px  #be8f57;
            }
        }

        /* Variabel */

        p {
            margin: 0;
            padding: 0;
        }

        .logo-maniac {
            width: var(--logo-maniac);
        }

        .container-page-1 {
            padding-top: 5%;
        }

        .container-page-2 {
            margin-top: 6%
        }

        .container-page-4 {
            margin-top: 6%;
            margin-bottom: 10%;
        }

        .container-page-6 {
            margin-top: 80%;
        }

        .container-juara {
            top: 20%;
            width: 100%;
            position: relative;
        }

        /* Text */
        .win-up{
            margin: 135px;
            padding: 50px;
            width: 850px;
        }

        .text-timeline,
        .text-join-now,
        .text-prizes {
            color: #733b22;
            margin: 1% 0 1% 0;
            font-family: dalek;
            font-weight: 300;
            text-shadow: -3px 3px  #be8f57;
        }

        .text-prizes {
            font-size: var(--fs-prizes);
        }

        .text-join-now {
            font-size: var(--fs-join-now);
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
            opacity: 1;
        }
        
        .dec-3-1{ 
            z-index: -1;
        }

        .dec-3-2 {
            z-index: -1;
        }

        .dec-3-4 {
            margin-bottom: 37%;
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
        
        /* Bird */
        .burung{
            position: absolute;
            width: 22%;
            z-index: 0;
        }

        .burung-kiri-atas{
            top: 9%;
            left: -1%;
        }
        
        .burung-kanan-tengah{
            top: 80%;
            right: -6%;
            transform: scaleX(-1);
        }

        .burung-kiri-bawah{
            left: -9%;
            bottom: -110%;
        }
        /* Bird */

        /* Button */
        .register-now {
            margin: 95px;
            
        }
        .button-register
        {
            width: 600px;
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

        .poster {
            margin: 30px;
            margin-bottom: 100px;
            width: 80%;
        }

        /* Poster */

        /* Timeline */
        .timeline {
            width: 90%;
            margin-bottom: 73px;
            transform: translateY(38%);
        }

        /* Title*/
        .joinNow-title,
        .prize-title,
        .timeline-title {
            width: 30%;
            max-width: 400px;
        }

        

        /* Juara */
        .juara {
            padding-top: 2vw;
            width: 25vw;
            margin-top: 100px;
            position: relative;
        }
        
        .juara-1-1 {
            margin-left: 2.5vw;
            margin-right: 2.5vw;
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
            margin-bottom: 50%;
            border-bottom: 1px solid #D9D9D9;
            border-radius: var(--video-container-br);
            background-color: #B34A37;
            box-shadow: 0 4px 6px -2px gray;
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
    <div class="container-xxl">
        <div class="container-page-1 position-relative">
            <div class="d-flex align-items-center flex-column" data-aos="fade-up">
                <img src="{{ asset('asset2026/Title.png') }}" alt="Logo Maniac" class="logo-maniac mb-3 z-1">
            </div>
        </div>
        <div class="container-page-2 position-relative">
            <img src="{{asset('asset2025/pendaftaran/burung.png')}}" class="burung burung-kiri-atas">
            <div class="d-flex align-items-center flex-column">
                <img src="{{ asset('asset2026/win-up.png') }}" class="win-up">
                <div class="register-now">
                    <img href="{{ url('/register') }}" src="{{ asset('asset2026/Register-Button.png') }}" class="button-register">
                </div>
            </div>
        </div>
        <div class="container-page-3 position-relative" data-aos="fade-down" data-aos-delay="50">
            <img src="{{asset('asset2025/pendaftaran/burung.png')}}" class="burung burung-kanan-tengah">
            <div class="container-axe d-flex justify-content-center ">
                <!--<img src="{{ asset('asset2024/main/axe.png') }}" class="position-absolute axe axe-1">
                <img src="{{ asset('asset2024/main/axe.png') }}" class="position-absolute axe axe-2">-->
            </div>
                        <div class="container-poster d-flex justify-content-center">
                            <img src="{{ asset('asset2026/home/Poster.png') }}" alt="Poster Maniac" class="poster">
                        </div>
            </div>
        </div>
        <div class="container-page-4 position-relative" data-aos="fade-right" data-aos-delay="100">
            <div class="d-flex justify-content-center flex-column align-items-center">
                <img src="{{ asset('asset2025/pendaftaran/3.png') }}" class="dec-3 dec-3-1">
                <img src="{{ asset('asset2026/home/Timeline.png') }}" class="timeline-title">
                <img src="{{ asset('asset2025/pendaftaran/3.png') }}" class="dec-3 dec-3-2">
                <img src="{{ asset('asset2025/timeline.png') }}" alt="Timeline Maniac" class="timeline">
            </div>
        </div>
        <div class="container-page-5 position-relative" data-aos="fade-left" data-aos-delay="100">
            <img src="{{asset('asset2025/pendaftaran/burung.png')}}" class="burung burung-kiri-bawah">
            <div class="d-flex justify-content-center flex-column align-items-center ">
                <img src="{{ asset('asset2026/home/Prizes.png') }}" class="prize-title">
                <div class="container-juara position-absolute">
                    <div class="img-juara-1 d-flex justify-content-center align-items-center">
                        <img src="{{ asset('asset2025/pendaftaran/juara-2.png') }}" alt="Juara I" class="juara juara-1-2">
                        <img src="{{ asset('asset2025/pendaftaran/juara-1.png') }}" alt="Juara II" class="juara juara-1-1">
                        <img src="{{ asset('asset2025/pendaftaran/juara-3.png') }}" alt="Juara III" class="juara juara-1-3">
                    </div>
                    <div class="img-juara-2 d-flex justify-content-center align-items-center">
                        <img src="{{ asset('asset2025/pendaftaran/Harapan -1.png') }}" alt="Harapan I" class="juara-2 juara-2-1">
                        <img src="{{ asset('asset2025/pendaftaran/text-usp.png') }}" alt="Teks usp" class="container-usp">
                        <img src="{{ asset('asset2025/pendaftaran/Harapan -2.png') }}" alt="Harapan II" class="juara-2 juara-2-2">
                    </div>
                </div>
                {{-- <div class="container-text-3 d-flex justify-content-center flex-column ">
                    <p>*Terdiri atas 3 orang dari SMA/SMK yang sama</p>
                    <p>*&#41;USP berlaku jika masuk Program Studi Teknik Informatika Program Digital Media Technology</p>
                </div> --}}
            </div>
        </div>
        
        {{-- <div class="container-page-6"  data-aos="fade-down" data-aos-delay="50">
            <div class="d-flex justify-content-center flex-column align-items-center ">
                <img src="{{ asset('asset2025/pendaftaran/3.png') }}" class="dec-3 dec-3-1">
                <h1 class="text-prizes">Workshop</h1>
                <img src="{{ asset('asset2025/pendaftaran/3.png') }}" class="dec-3 ">
            </div>
            <div class="position-relative">
                <img src="{{asset('asset2025/pendaftaran/burung.png')}}" class="burung burung-kanan-tengah">
                <div class="container-axe d-flex justify-content-center ">
                    <!--<img src="{{ asset('asset2024/main/axe.png') }}" class="position-absolute axe axe-1">
                    <img src="{{ asset('asset2024/main/axe.png') }}" class="position-absolute axe axe-2">-->
                </div>
                <div class="wrap-axe-poster">
                    <div class="container-axe-poster d-flex justify-content-center">
                        <img src="{{ asset('asset2025/pendaftaran/2.png') }}" class="dec-2 dec-2-1">
                        <div class="wrap-poster d-flex justify-content-center position-relative">
                            <div class="container-poster d-flex justify-content-center">
                                <img src="{{ asset('asset2025/pendaftaran/poster-workshop.png') }}" alt="Poster Workshop" class="poster w-100">
                            </div>
                        </div>
                        <div class="wrap-dec-2">
                            <img src="{{ asset('asset2025/pendaftaran/2.png') }}" class="dec-2 dec-2-2 position-absolute">
                        </div>
                    </div>
                </div>
            </div>
        </div>--}}

        <div class="container-page-6 position-relative">
            <!-- <img src="{{ asset('asset2025/pendaftaran/cloud/c4.png') }}" class="position-absolute c-c1"> -->
            <div class="container-text-iframe d-flex justify-content-center flex-column align-items-center ">
                <img src="{{ asset('asset2025/pendaftaran/3.png') }}" class="dec-3 dec-3-1">
                <img src="{{ asset('asset2026/home/Join Now.png') }}" class="joinNow-title">
                <img src="{{ asset('asset2025/pendaftaran/3.png') }}" class="dec-3 dec-3-2">
                <div class="container-video d-flex justify-content-center align-items-center z-1" data-aos="zoom-in"
                    data-aos-delay="50">
                    <iframe src="https://www.youtube.com/embed/KxdrfSuRerc?si=fkgBesLHYBUQIa3K" frameborder="0"
                        class="iframe d-flex align-items-center justify-content-center"></iframe>
                </div>
            </div>
        </div>
    </div>
@endsection
