@extends('visitor.welcome')

@section('styles')
    <style>
        @font-face {
            font-family: 'Rustler';
            src: url("{{ asset('fonts/rustler/RUSTLER_.TTF')}}") format("opentype");
            font-weight: 500;
        }

        @font-face {
            font-family: 'Montserrat';
            src: url("../fonts/montserrat/Montserrat-SemiBold.otf") format("otf");
            font-weight: 300;
        }

        @font-face {
            font-family: 'Montserrat';
            src: url("../fonts/montserrat/Montserrat-Bold.otf") format("otf");
            font-weight: 500;
        }

        @font-face {
            font-family: 'Montserrat';
            src: url("../fonts/montserrat/Montserrat-ExtraBold.otf") format("otf");
            font-weight: 700;
        }


        @media (max-width: 575px) {
            :root {
                /* Ambil width : 420 */
                --height-wrap-all: 80vh;
                --width-input-1: 16em;
                --width-button: 150%;
                --form-p: 3% 5%;
            }
        }

        @media (min-width: 576px) {
            :root {
                /* Titik tengah : 672 */
                --height-wrap-all: 110vh;
                --width-input-1: 21em;
                --width-button: 150%;
                --form-p: 1% 2%;

            }
        }

        a {
            color: #2300FD;
            font-size: 12px;
            font-weight: 450;
        }

        label {
            color: #733b22;
        }

        .mt-4{
            margin-left: 20px;
            margin-right: 20px;
        }

        .input-1 {
            padding-left: 2%;
            width: var(--width-input-1);
            border:1px solid #be8f57;
            border-radius: 8px;
            background-color: #DCE2E2;
        }

        .wrap-all {
            padding-bottom: 4%;
            font-family: 'Creato Display', sans-serif !important;
            font-weight: 700;
            letter-spacing: 1.2px;
            width: 100vw;
            height: var(--height-wrap-all);
        }

        .logo-maniac {
            width: 50%;
            margin-bottom:2%;
        }

        .dec-1 {
            width: 17%;
            transform: rotate(3.14159rad);
        }

        .dec-2 {
            width: 17%;
        }

        .container-form {
            padding: 0;
            border: 2px solid #be8f57;
            border-radius: 21px;
            background-color: #FBF5E5;
            backdrop-filter: blur(8px);
        }

        .text-login {
            color: #733b22;
            font-family: 'Rustler', sans-serif !important;
            font-weight: 700;
            font-size: 3.5rem;
            text-shadow: -1px 3px 0px #be8f57;
            margin-top: 30px;
            margin-bottom: 20px;
        }

        .button {
            margin-top: 20%;
            width: var(--width-button);
            border-radius: 10px;
            font-size: 15px;
            font-weight: 700;
            background-color: #be8f57;
            color: #D9D9D9;
            margin-bottom: 25%;
            left: 0;
        }

        .button:hover {
            color: #D9D9D9;
            background-color: #8E5324;
        }

        .txtPass {
            position: relative;
        }

        .togle-position {
            position: absolute;
            right: 5px;
            top: 55%;
            transform: translate(0, -50%);
        }

        .register-box {
            margin-top: 12px;
            bottom: -22%;
            background-color: #8E5324;
            color: white;
            border-bottom-left-radius: 19px;
            border-bottom-right-radius: 19px;
            text-align: center;
            border: 1px solid #733b22;
            width: 100%;
        }

        .register-box p, .register-box a{
            font-size: 12px;
            font-family: Lato;
            margin-top: 15px;
            color: #fff;
        }

        .burung {
            position: absolute;
            width: 19%;
        }

        .burung-kanan {
            transform: scaleX(-1);
            top: 10%;
            right: 0%;
        }

        .burung-kiri {
            top: 40%;
            left: 0%;
        }

        @media (min-width: 0px) and (max-width: 380px) {
            img.logo-maniac {
                width: 90%;
            }

            .text-login {
                text-shadow: -2px 1.5px 0px #be8f57;
            }

            .burung-kanan {
                top: 25%;
            }
        }

        @media (min-width: 381px) and (max-width: 575px) {
            .wrap-all img {
                width: 48vw;
            }

            img.logo-maniac {
                width: 80%;
            }

            .burung-kanan {
                top: 25%;
            }

            .text-login {
                text-shadow: -3px 2px 0px #be8f57;
            }
        }

        @media (min-width: 576px) and (max-width: 768px) {
            .wrap-all img {
                width: 35vw;
            }

            img.logo-maniac {
                width: 70%;
            }

            .text-login {
                text-shadow: -3px 2px 0px #be8f57;
            }
        }

        @media (min-width: 769px) and (max-width: 992px) {
            .wrap-all img {
                width: 30vw;
            }

            img.logo-maniac {
                width: 70%;
            }

            .text-login {
                text-shadow: -3px 2px 0px #be8f57;
            }
        }

        @media (min-width: 993px) and (max-width: 1200px) {
            .wrap-all img {
                width: 25vw;
            }

            img.logo-maniac {
                width: 70%;
            }

            .text-login {
                text-shadow: -4px 3px 0px #be8f57;
            }
        }

        @media (min-width: 1201) {
            img.logo-maniac {
                width: 15%;
            }

            .text-login {
                text-shadow: -4px 3px 0px #be8f57;
            }
        }



        .show-password path:nth-child(1),
        .show-password path:nth-child(3),
        .show-password path:nth-child(5),
        .show-password path:nth-child(7),
        .show-password path:nth-child(9),
        .show-password path:nth-child(11),
        .show-password path:nth-child(13),
        .show-password path:nth-child(15) {
            display: none;
        }

        .show-password path:nth-child(2),
        .show-password path:nth-child(4),
        .show-password path:nth-child(6),
        .show-password path:nth-child(8),
        .show-password path:nth-child(10),
        .show-password path:nth-child(12),
        .show-password path:nth-child(14),
        .show-password path:nth-child(16) {
            display: block;
        }

        .error-password{
            width: 40%;
        }

        /* Hide default edge/chrome password reveal icon */
        input[type="password"]::-ms-reveal,
        input[type="password"]::-ms-clear {
            display: none;
        }
    </style>
@endsection


@section('content')
    <div class="container-fluid m-0 p-0">
        <div class="wrap-all d-flex justify-content-center align-items-center flex-column ">
            <img data-aos="fade-in" src="{{ asset('asset2026/Title.webp') }}" alt="logo-maniac" class="logo-maniac z-1">
            @if (session()->has('gagal'))
                <div class="alert alert-danger" role="alert">
                    {{ session()->get('gagal') }}
                </div>
            @endif
            @error('gagal')
                <div class="alert alert-success" role="alert">
                    {{ $message }}
                </div>
            @enderror
            <div class="container-form d-flex justify-content-center align-items-center z-1" data-aos="zoom-in"
                data-aos-delay="50">
                <form method="POST" action="{{ route('login') }}"
                    class="d-flex justify-content-center align-items-center flex-column">
                    @csrf
                    <h1 class="text-login">LOGIN</h1>
                    {{-- <p>Coming Soon MANIAC XV</p> --}}
                    {{-- Hapus Jika Webnya sudah Fix --}}
                    <!-- Email Address -->
                    <div>
                        <label for="username" :value="__('Username')">Username</label>
                        <br>
                        <input id="username" class="input-1 block mt-1 w-full @error('username') is-invalid @enderror"
                            type="text" name="username" :value="old('username')" autofocus autocomplete="username" />
                        @error('username')
                            <div class="invalid-feedback alert-danger mw-100"
                                style="max-width: 21em !important;
                            overflow-wrap: break-word !important;
                            word-wrap: break-word !important;">
                                <!-- style="left: 0; width: 100%; top: 100%;" -->
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mt-4 position-relative">
                        <label for="password" :value="__('Password')">Password</label>
                        <div class=" txtPass rounded ">
                            <input id="password" class="input-1 block mt-1 w-full @error('password') is-invalid @enderror"
                            type="password" name="password" autocomplete="current-password" />

                            <!-- Ganti src ini dengan path gambar mata tertutup milikmu -->
                            <img src="{{ asset('asset2026/pendaftaran/hide.webp') }}" class="togle-position eye-close" onclick="togglePasswordVisibility()" style="width: 25px; cursor: pointer;">

                            <!-- Ganti src ini dengan path gambar mata terbuka milikmu -->
                            <img src="{{ asset('asset2026/pendaftaran/show.webp') }}" class="togle-position eye" onclick="togglePasswordVisibility()" style="width: 25px; cursor: pointer; display: none;">
                            @error('password')
                                <div id="sumberError" class="error-password invalid-feedback alert-danger" >
                                    {{ $message }}
                                </div>

                            @enderror
                        </div>
                        <div id="error" style="max-width: 21em !important;
                            overflow-wrap: break-word !important;
                            word-wrap: break-word !important; font-size: 0.8rem;" class="text-danger alert-danger"></div>


                        <script defer>
                            let sumberError = document.getElementById("sumberError");
                            let nilai = sumberError.innerHTML;
                            let nodeError = document.getElementById("error");
                            sumberError.innerHTML = "";

                            console.log(nilai.innerHTML);
                            console.log(nodeError);
                            nodeError.innerHTML = nilai;
                        </script>
                    </div>

                    <div class="mt-3 d-flex align-items-center flex-column">
                        <!-- Forgot your password? -->
                        <div>
                            @if (Route::has('password.request'))
                                <a class="underline text-sm rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 text-decoration-none"
                                    href="{{ route('password.request') }}">
                                    {{ __('Forgot your password?') }}
                                </a>
                            @endif
                        </div>

                        <!-- Button Log in -->
                        <button type="submit" class="bg-transparent border-0 p-0" style="margin-top: 1.5rem; margin-bottom: 2rem; display: flex; justify-content: center; width: 100%;">
                            <img src="{{ asset('asset2026/pendaftaran/login.webp') }}" alt="Log in" style="width: 70%; max-width: 220px; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                        </button>
                    </div>
                    <div class="register-box d-flex align-items-center flex-column">
                        <p>Not registered yet? <a class="register-link" href="https://maniacubaya.com/register" target="_blank">Click to register</a></p>
                    </div>
            </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>

        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const eyeOpen = document.querySelector('.eye');
            const eyeClose = document.querySelector('.eye-close');

            if (passwordInput.getAttribute('type') === 'password') {
                passwordInput.setAttribute('type', 'text');
                eyeOpen.style.display = 'block';
                eyeClose.style.display = 'none';
            } else {
                passwordInput.setAttribute('type', 'password');
                eyeOpen.style.display = 'none';
                eyeClose.style.display = 'block';
            }
        }
    </script>
@endsection
