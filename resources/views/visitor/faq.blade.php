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
                                <strong>MANIAC (Multimedia ANd Interactive Art Competition)</strong> adalah lomba berbasis
                                multimedia untuk
                                anak SMA/K sederajat yang mencakup <em>Rally Games</em>, <em>Game Concept Design</em>, dan <em>Game Asset Design</em>
                                yang diselenggarakan oleh Program Studi Teknik Informatika Program Digital Media Technology
                                Universitas Surabaya.
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="50">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <span>
                                    Apakah MANIAC XIV akan diadakan
                                    secara&nbsp;<em>online</em>&nbsp;atau&nbsp;<em>offline</em>?
                                </span>
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <em>Online</em> untuk babak penyisihan. <em>Offline</em> di Universitas Surabaya untuk <em>Technical meeting</em>, 
                                babak Semifinal,
                                dan babak Final.
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="100">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Apa saja tahap dalam MANIAC XIV?
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <ul>
                                    <li>Babak Penyisihan</li>
                                    <li><em>Technical Meeting </em> Babak Semi Final</li>
                                    <li>Babak Semi Final</li>
                                    <li><em>Technical Meeting </em> Babak Final</li>
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
                                Apakah MANIAC XIV bersifat akademis (seperti mengerjakan soal-soal
                                pelajaran)?
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Tidak, Maniac XIV berfokus pada bidang Multimedia. Bidang akademis hanya akan diuji di
                                beberapa pos pada <em>rally games</em>.
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="200">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                Apakah bidang lomba yang diujikan hanya tentang Digital Media
                                Technology?
                            </button>
                        </h2>
                        <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                MANIAC berfokus pada 2 bidang Multimedia, yaitu <em>Game Concept Design
                                </em> dan <em>Game Asset Design</em>.
                                Namun terdapat bidang Multimedia selain game pada babak semifinal.
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="250">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                Apakah akan ada pelatihan sebelum pelaksanaan acara?
                            </button>
                        </h2>
                        <div id="collapseSix" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Ya, akan ada Workshop yang bersifat tidak wajib namun dapat diikuti sebagai bekal untuk lomba MANIAC
                                <um>
                                    <li>Workshop <em>Game Concept Design</em> & Workshop <em>Game Asset Design</em> pada tanggal 31 Mei 2025.</li>
                                </um>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="300">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                                <span>
                                    <em>Software</em>&nbsp;apa yang digunakan selama lomba?
                                </span>
                            </button>
                        </h2>
                        <div id="collapseSeven" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Untuk pengerjaan, <em>software</em> yang digunakan dibebaskan bagi para peserta, 
                                namun penggunaan <em>software Artificial Intelligence </em> untuk <em>generate</em> hasil karya tidak diperbolehkan.
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="350">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                                Bagaimana cara mendaftar menjadi peserta MANIAC XIV?
                            </button>
                        </h2>
                        <div id="collapseEight" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Pendaftaran dilakukan secara <em>online</em> dengan mengisi form pendaftaran yang tersedia
                                di website
                                <strong><a href="https://maniacubaya.com" target="_blank" style="color:skyblue">maniacubaya.com</a></strong>.
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="400">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                                <span>
                                    Bagaimana cara mendaftar menjadi peserta <em>workshop</em>?
                                </span>
                            </button>
                        </h2>
                        <div id="collapseNine" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Pendaftaran dilakukan secara <em>online</em> dengan mengisi form pendaftaran 
                                pada link berikut <a href="https://bit.ly/PendaftaranWorkshopManiacXIV" target="_blank" style="color:skyblue">bit.ly/PendaftaranWorkshopManiacXIV</a> 
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="450">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
                                <span>
                                    Bagaimana&nbsp;<em>timeline</em>&nbsp;lomba MANIAC XIV?
                                </span>
                            </button>
                        </h2>
                        <div id="collapseTen" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <ul>
                                    <li>Pengumuman Penyisihan (21 Juli 2025)</li>
                                    <li>Masa Pengerjaan Penyisihan (21 - 22 Juli 2025)</li>
                                    <li>Babak Penjurian (23 - 25 Juli 2025)</li>
                                    <li>Pemberitahuan Semifinalis (25 Juli 2025)</li>
                                    <li>Babak Semifinal (26 Juli 2025)</li>
                                    <li><em>Technical Meeting</em> Babak Final (26 Juli 2025)</li>
                                    <li>Masa Pengerjaan Final (26 - 29 Juli 2025)</li>
                                    <li>Babak Final (30 Juli 2025)</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="500">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseEleven" aria-expanded="false" aria-controls="collapseEleven">
                                Berapakah biaya pendaftaran untuk MANIAC XIV?
                            </button>
                        </h2>
                        <div id="collapseEleven" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <ul>
                                    <li>Pendaftaran untuk mengikuti lomba dikenakan biaya sebesar Rp40.000,00/tim (Early Bird) 
                                        & Rp65.000,00/tim (Normal), 
                                        terdapat juga potongan biaya pendaftaran bagi sekolah yang mendaftarkan 3 tim/lebih sebesar Rp40.000,00</li>
                                    <li>
                                        Pendaftaran workshop tidak dikenakan biaya (GRATIS).
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="550">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwelve" aria-expanded="false" aria-controls="collapseTwelve">
                                <span>
                                    Apakah terdapat batasan jumlah tim yang mendaftar (dari tiap sekolah)?
                                </span>
                            </button>
                        </h2>
                        <div id="collapseTwelve" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Tidak ada.
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="600">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse13" aria-expanded="false" aria-controls="collapse13">
                                Berapa jumlah orang dalam satu tim ?
                            </button>
                        </h2>
                        <div id="collapse13" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                3 anggota dari sekolah yang sama.
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="650">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse14" aria-expanded="false" aria-controls="collapse14">
                                Dimana saya dapat memperoleh informasi terkait MANIAC XIV?
                            </button>
                        </h2>
                        <div id="collapse14" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <ul>
                                    <li>Website: maniacubaya.com</li>
                                    <li>IG: maniac_ubaya</li>
                                    <li>OA Line: @994nxsfr</li>
                                    <li>Email: maniac.ubayaa@gmail.com</li>
                                    <li>CP: Nicho (WA: 089699833080), Gioshelyn (WA: 085330001180)</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="700">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse15" aria-expanded="false" aria-controls="collapse15">
                                Dimana saya dapat melihat kisi-kisi perlombaan?
                            </button>
                        </h2>
                        <div id="collapse15" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Semua informasi mengenai lomba akan diinfokan melalui Instagram MANIAC XIV.
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="750">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse16" aria-expanded="false" aria-controls="collapse16">
                                <span>
                                    Apakah wajib mengikuti&nbsp;<em>Technical Meeting</em>?
                                </span>
                            </button>
                        </h2>
                        <div id="collapse16" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Setiap tim wajib mengirimkan salah satu perwakilan tim.
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="800">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse17" aria-expanded="false" aria-controls="collapse17">
                                Batas pendaftaran MANIAC XIV hingga kapan?
                            </button>
                        </h2>
                        <div id="collapse17" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <ul>
                                    <li>5 Mei - 24 Mei 2025 (Open Registration Workshop)</li>
                                    <li>5 Mei - 5 Juni 2025 (Open Registration Lomba <em>Early Bird</em>)</li>
                                    <li>9 Juni - 16 Juli 2025 (Open Registration Lomba Normal)</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="850">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse18" aria-expanded="false" aria-controls="collapse18">
                                Apa saja yang dilombakan pada babak utama penyisihan dan final?
                            </button>
                        </h2>
                        <div id="collapse18" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <ul>
                                    <li>Penyisihan: Proposal <em>Game Concept Design</em> dan <em>Game Asset Design</em>.</li>
                                    <li>Semi Final: <em>Rally Games</em></li>
                                    <li>Final: <em>Game Concept Design</em> dan <em>Game Asset Design</em></li>
                                </ul>
                                Selengkapnya dapat dilihat pada 
                                <a href="https://maniacubaya.com/competition" target="_blank" style="color:skyblue">maniacubaya.com/competition</a>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="900">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse19" aria-expanded="false" aria-controls="collapse19">
                                Apakah kelas 12 boleh mengikuti MANIAC XIV?
                            </button>
                        </h2>
                        <div id="collapse19" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Untuk kelas 12 angkatan lulus Tahun Ajaran 2024/2025 tidak diperbolehkan, sedangkan untuk
                                angkatan yang naik ke kelas 12 pada Tahun Ajaran 2025/2026 diperbolehkan, asalkan mendapat
                                izin dari sekolah dan memiliki bukti status kesiswaan.
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="950">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse20" aria-expanded="false" aria-controls="collapse20">
                                Apakah diperbolehkan jika teman satu kelompok berbeda angkatan?
                            </button>
                        </h2>
                        <div id="collapse20" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Diperbolehkan, dengan syarat tetap berada di jenjang yang sama (SMA/K sederajat), dan untuk
                                kelas 12 mengikuti ketentuan pada pertanyaan sebelumnya (no.19).
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="1000">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse21" aria-expanded="false" aria-controls="collapse21">
                                Apakah ada keringanan apabila terdapat gangguan koneksi?
                            </button>
                        </h2>
                        <div id="collapse21" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Tidak ada, risiko ditanggung masing-masing peserta.
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="accordion-item" data-aos="fade-up" data-aos-delay="1050">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse22" aria-expanded="false" aria-controls="collapse22">
                                Apakah diperbolehkan menggantikan rekan satu tim jika mendadak tidak bisa
                                mengikuti MANIAC XIV?
                            </button>
                        </h2>
                        <div id="collapse22" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Diperbolehkan, namun ada batasan waktu, yaitu 2 minggu sebelum pelaksanaan lomba 
                                yaitu paling lambat tanggal 7 Juli 2025.
                            </div>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
        </div>
    </div>
@endsection
