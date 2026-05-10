@extends('visitor.welcome')

@section('styles')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700;900&display=swap');

        .accordion-header>button {
            border-radius: 20px;
        }

        .accordion-button:not(.collapsed) {
            border-bottom-left-radius: 0px;
            border-bottom-right-radius: 0px;
        }

        .accordion-button {
            background-color: #8b181b;
            color: white;
            font-family: Lato;
            font-weight: bold;
            transition: 400ms;
        }

        .accordion-button:not(.collapsed) {
            background-color: #8b181b;
            color: #fff;
        }

        .bg-faq {
            background-color: #8b181b;
        }

        .accordion-body {
            background-color: #7f4c32;
            color: white;
            border-top-left-radius: 0px;
            border-top-right-radius: 0px;
            border-bottom-left-radius: 20px;
            border-bottom-right-radius: 20px;
            font-family: Lato;
        }

        .burung{
            position: absolute;
            width: 15vw;
            z-index: -1;
        }

        .burung-kanan-atas{
            top: 0;
            transform: scaleX(-1);
            right: -7%;
        }

        .burung-kiri-tengah{
            left: -7%;
        }

        .burung-kanan-bawah{
            transform: scaleX(-1);
            right: -7%;
            top: 50%;
            width: 13vw;
        }

        .faq-title{
            width: var(--faq-title);
        }

        @media screen and (max-width: 575px) {
            :root{
                --faq-title: 60%;
            }
            
            .burung {
                width: 30vw;
            }

            .burung-kanan-atas {
                top: 4%;
                right: -14%;
            }

            .burung-kiri-tengah {
                left: -14%;
            }

            .burung-kanan-bawah {
                right: -14%
            }
        }

        @media (min-width: 576px) and (max-width: 768px) {
            :root{
                --faq-title: 60%;
            }
            
            .burung {
                width: 30vw;
            }

            .burung-kanan-atas {
                top: 2.5%;
                right: -14%;
            }

            .burung-kiri-tengah {
                left: -14%;
            }

            .burung-kanan-bawah {
                right: -13%
            }
        }

        @media (min-width: 769px) and (max-width: 992px) {
            :root{
                --faq-title: 60%;
            }
            
            .burung {
                width: 26vw;
            }

            .burung-kanan-atas {
                top: 0;
                right: -13%;
            }

            .burung-kiri-tengah {
                left: -13%;
            }

            .burung-kanan-bawah {
                right: -12%
            }
        }

        @media (min-width: 993px) and (max-width: 1200px) {
            :root{
                --faq-title: 60%;
            }
            
            .burung {
                width: 20vw;
            }

            .burung-kanan-atas {
                top: 0;
                right: -10%;
            }

            .burung-kiri-tengah {
                left: -10%;
            }

            .burung-kanan-bawah {
                right: -10%
            }
        }

        @media screen and (min-width: 1201px) {
            :root{
                --faq-title: 60%;
            }
            
            .burung {
                width: 17vw;
            }

            .burung-kanan-atas {
                top: 0;
                right: -8%;
            }

            .burung-kiri-tengah {
                top: 15%;
                left: -8%;
            }

            .burung-kanan-bawah {
                right: -8%;
                top: 35%;
            }
        }

    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="container py-5 d-flex align-items-center flex-column">
            <img src="{{ asset('asset2026/FAQ/faq_title.png') }}" alt="FAQ-title" class="faq-title">
            <br>
            <div class="faq">
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item" data-aos="fade-up">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Apa itu MANIAC?
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <strong>MANIAC (Multimedia and Interactive Art Competition)</strong> merupakan lomba berbasis multimedia untuk anak SMA/K sederajat yang mencakup Penyisihan (online), Semi Final (Rally Games & Game Besar), dan Final (presentasi). Materi yang dilombakan adalah mengenai User Interface dan User Experience. MANIAC diselenggarakan oleh Program Studi Teknik Informatika Program Digital Media Technology Universitas Surabaya.
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="50">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <span>
                                    Apakah MANIAC XV akan diadakan
                                    secara&nbsp;<em>online</em>&nbsp;atau&nbsp;<em>offline</em>?
                                </span>
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <em>Online</em> untuk babak Penyisihan. <em>Offline</em> di Universitas Surabaya untuk <em>Technical Meeting</em> &nbsp;FINAL, babak Semifinal, dan babak Final.
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="100">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Apa saja tahap dalam MANIAC XV?
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <ul>
                                    <li>Babak Penyisihan</li>
                                    <li><em>Technical Meeting </em> &nbsp;Babak Semi Final</li>
                                    <li>Babak Semi Final</li>
                                    <li><em>Technical Meeting </em> &nbsp;Babak Final</li>
                                    <li>Babak Final</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="150">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                Bagaimana timeline MANIAC XV?
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <ul>
                                    <li>Masa Pengerjaan Penyisihan (12 Mei - 21 Juli 2026)</li>
                                    <li>Babak Penjurian (22 - 24 Juli 2026)</li>
                                    <li>Pengumuman Finalis (26 Juli 2026)</li>
                                    <li>Babak Semifinal (1 Agustus 2026)</li>
                                    <li><em>Technical Meeting</em> &nbsp;Babak Final (1 Agustus 2026)</li>
                                    <li>Final (3 Agustus 2026)</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="200">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                Berapa jumlah anggota tim untuk mengikuti lomba MANIAC XV?
                            </button>
                        </h2>
                        <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Maksimal 3 anggota per tim dari sekolah yang sama.
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="250">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                Apakah terdapat batasan jumlah tim yang mendaftar (dari tiap sekolah)?
                            </button>
                        </h2>
                        <div id="collapseSix" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Tidak ada.
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="300">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                                <span>
                                    Bagaimana cara mendaftarkan sebagai peserta lomba MANIAC XV?
                                </span>
                            </button>
                        </h2>
                        <div id="collapseSeven" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Pendaftaran dapat dilakukan secara online melalui website <strong><a href="https://maniacubaya.com" target="_blank" style="color:skyblue">maniacubaya.com</a></strong>.
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="350">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                                Berapakah biaya untuk daftar MANIAC XV?
                            </button>
                        </h2>
                        <div id="collapseEight" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Untuk biaya pendaftaran lomba MANIAC XV sebesar Rp 40.000/tim (Early Bird) dan Rp 65.000/tim (Normal). Jika pendaftaran 3 tim atau lebih (dari sekolah yang sama) secara langsung akan mendapat potongan harga menjadi Rp 40.000/tim
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="400">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                                <span>
                                    Bagaimana informasi lebih lanjut terkait MANIAC XV bisa didapatkan?
                                </span>
                            </button>
                        </h2>
                        <div id="collapseNine" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                 <ul>
                                    <li>Website: <strong><a href="https://maniacubaya.com" target="_blank" style="color:skyblue">maniacubaya.com</a></strong>.</li>
                                    <li>IG: <strong><a href="https://www.instagram.com/maniac_ubaya" target="_blank" style="color:skyblue">@maniac_ubaya</a></strong>.</li></li>
                                    <li>OA Line: @994nxsfr</li>
                                    <li>Email: maniac.ubayaa@gmail.com</li>
                                    <li>CP: Nadya (WA: 082232958165), Jovanka (WA: 082229088089)</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="450">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
                                <span>
                                    Bagaimana pengumpulan karya lomba dan sampai kapan pengerjaanya?
                                </span>
                            </button>
                        </h2>
                        <div id="collapseTen" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Pengumpulan proposal dan prototype dapat dikumpulkan sampai penutupan pendaftaran.
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="500">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseEleven" aria-expanded="false" aria-controls="collapseEleven">
                                Apakah semua anggota tim wajib hadir di <em>Technical Meeting</em> ?
                            </button>
                        </h2>
                        <div id="collapseEleven" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Semua tim wajib menghadiri <em>Technical Meeting</em> &nbsp;dengan mengirimkan salah satu perwakilan tim.
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="550">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwelve" aria-expanded="false" aria-controls="collapseTwelve">
                                <span>
                                    Darimana saya mengetahui tentang S&K tentang perlombaan?
                                </span>
                            </button>
                        </h2>
                        <div id="collapseTwelve" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Informasi mengenai perlombaan MANIAC XV akan di informasikan melalui instagram MANIAC XV
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="600">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse13" aria-expanded="false" aria-controls="collapse13">
                                Sampai kapan batas pendaftaran MANIAC XV?
                            </button>
                        </h2>
                        <div id="collapse13" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <ul>
                                    <li>Open Registrasi Lomba (EarlyBird)  : 12 Mei 2026 - 2 Juni 2026</li>
                                    <li>Open Registrasi Lomba (Normal)  : 3 Juni 2026 - 17 Juli 2026</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="650">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse14" aria-expanded="false" aria-controls="collapse14">
                                Apakah yang diujikan pada perlombaan hanya tentang Digital Media Technology?
                            </button>
                        </h2>
                        <div id="collapse14" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                MANIAC berfokus pada 2 bidang yaitu <em>UI (User Interface)</em> &nbsp;dan <em>UX (User Experience)</em>. Juga terdapat Rally Games yang akan dilakukan pada babak semifinal.
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="700">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse15" aria-expanded="false" aria-controls="collapse15">
                                Apa saja yang akan dilombakan pada babak penyisihan, semi final, dan final?
                            </button>
                        </h2>
                        <div id="collapse15" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <ul>
                                    <li>Penyisihan : Proposal karya desain <em>UI/UX</em></li>
                                    <li>Semi Final : <em>Rally Games</em></li>
                                    <li>Final : Presentasi hasil karya yang telah dibuat</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="750">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse16" aria-expanded="false" aria-controls="collapse16">
                                <span>
                                    Apakah kelas 12 boleh mengikuti MANIAC XV?
                                </span>
                            </button>
                        </h2>
                        <div id="collapse16" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Kelas 12 angkatan  2025/2026 dilarang berpartisipasi, sementara siswa yang baru memasuki kelas 12 diperbolehkan dengan izin sekolah dan bukti kesiswaan.
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="800">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse17" aria-expanded="false" aria-controls="collapse17">
                                Apakah diperbolehkan jika ada satu anggota yang berbeda angkatan?
                            </button>
                        </h2>
                        <div id="collapse17" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Diperbolehkan, dengan syarat tetap berada di jenjang yang sama (SMA/K sederajat) serta sekolah yang sama, dan untuk kelas 12 mengikuti ketentuan pada pertanyaan sebelumnya
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="850">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse18" aria-expanded="false" aria-controls="collapse18">
                                Apakah diperbolehkan menggantikan rekan satu tim jika mendadak tidak bisa mengikuti rangkaian lomba MANIAC XV?
                            </button>
                        </h2>
                        <div id="collapse18" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Diperbolehkan, untuk konfirmasi bisa dilakukan ke CP Nadya (WA: 082232958165)  2 minggu sebelum acara perlombaan di mulai.
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="900">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse19" aria-expanded="false" aria-controls="collapse19">
                                Jika salah satu anggota dalam satu tim tidak hadir dalam perlombaan MANIAC XV apakah diperbolehkan?
                            </button>
                        </h2>
                        <div id="collapse19" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Diperbolehkan, akan tetapi resiko ditanggung tim sendiri
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="950">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse20" aria-expanded="false" aria-controls="collapse20">
                                Apakah software yang digunakan untuk merancang UI terbatas pada Figma saja?
                            </button>
                        </h2>
                        <div id="collapse20" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Penggunaan software lain diperbolehkan, selama hasil prototype dapat dioperasikan dengan baik.
                            </div>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
        </div>
    </div>
@endsection
