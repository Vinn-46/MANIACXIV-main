@extends('visitor.welcome')

@section('styles')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700;900&display=swap');

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
            font-family: Lato !important; 
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
            background-color: #e7eadf;
            backdrop-filter: blur(8px);
        }

        .text-login {
            color: #733b22;
            font-family: dalek;
            font-weight: 100;
            text-shadow:-3px 2px  #be8f57;
            margin-bottom: 20px;
            margin-top: 20px;
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
            background-color: #733b22;
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
            background-color: #733b22;
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
                text-shadow: -1px 0.5px #be8f57;
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
                text-shadow: -2px 1px #be8f57;
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
                text-shadow: -2px 1px #be8f57;
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
                text-shadow: -2px 1px #be8f57;
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
                text-shadow: -3px 2px #be8f57;
            }
        }

        @media (min-width: 1201) {
            img.logo-maniac {
                width: 15%;
            }

            .text-login {
                text-shadow: -3px 2px #be8f57;
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
    </style>
@endsection


@section('content')
    <div class="container-fluid m-0 p-0">
        <img src="{{asset('asset2025/pendaftaran/burung.png')}}" class="burung burung-kanan">
        <img src="{{asset('asset2025/pendaftaran/burung.png')}}" class="burung burung-kiri">
        <div class="wrap-all d-flex justify-content-center align-items-center flex-column ">
            <img data-aos="fade-in" src="{{ asset('asset2025/logo-maniac-xiv.png') }}" alt="logo-maniac" class="logo-maniac z-1">
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
            <img src="{{ asset('asset2025/pendaftaran/3.png') }}" class="dec-1 z-1">
            <div class="container-form d-flex justify-content-center align-items-center z-1" data-aos="zoom-in"
                data-aos-delay="50">
                <form method="POST" action="{{ route('login') }}"
                    class="d-flex justify-content-center align-items-center flex-column">
                    @csrf
                    <h1 class="text-login">LOGIN</h1>
                    {{-- <p>Coming Soon MANIAC XIV</p> --}}
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
                           
                            <svg style="width: 20px; height:auto;" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                class="togle-position eye-close" onclick="togglePasswordVisibility()">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>

                            <svg style="width: 20px; height:auto;" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="togle-position eye"
                                onclick="togglePasswordVisibility()">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                            </svg>
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
                        <button class="button btn text-light">
                            {{ __('Log in') }}
                        </button>
                    </div>
                    {{-- Uncomment jika sudah fix --}}
                    <div class="register-box d-flex align-items-center flex-column">
                        <p>Not registered yet? <a class="register-link" href="https://maniacubaya.com/register" target="_blank">Click for register</a></p>
                    </div>
            </div>
            </form>
            <img src="{{ asset('asset2025/pendaftaran/3.png') }}" class="dec-2 z-1">
        </div>
    </div>
@endsection

@section('script')
    <script>
        
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const toggleReveal = document.querySelector('.eye');
            const toggleHidden = document.querySelector('.eye-close');

            if (passwordInput.getAttribute('type') === 'password') {
                passwordInput.setAttribute('type', 'text');
                toggleReveal.classList.add('show-password');
                toggleReveal.style.display('none');
            } else {
                passwordInput.setAttribute('type', 'password');
                toggleReveal.classList.remove('show-password');
            }
        }
    </script>
@endsection
