@extends('visitor.welcome')

@section('styles')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700;900&display=swap');

        :root {
            --competitions-title: 40%;
            --guidebook-title: 25%;
            /* Variabel ukuran font untuk responsivitas */
            --base-font-size: 16px;
            /* Ukuran dasar */
            --font-large: 2em;
            /* Besar */
            --font-medium: 1.5em;
            /* Sedang */
            --font-small: 1em;
            /* Kecil */

            /* Variabel warna */
            --color-bg: #8b181b;
            --color-fg: white;
            --color-primary: #733b22;
            --color-primary-dark: #8b181b;
        }

        .container-page {
            padding-top: 3%;
            text-align: center;
            position: relative;
        }

        .box-container {
            width: 70%;
            margin: 0 auto;
        }

        .sub {
            background-color: var(--color-bg);
            color: var(--color-fg);
            border-radius: 20px 20px 0 0;
            font-size: var(--font-large);
            padding: 10px;
            font-weight: bold;
            text-align: center;
            font-family: 'Lato';
        }

        .text {
            background-color: #733b22;
            color: var(--color-fg);
            border-radius: 0 0 20px 20px;
            padding: 30px;
            text-align: justify;
            font-family: 'Roboto';
            font-weight: abold;
            font-size: var(--font-medium);
        }

        h1 {
            color: #733b22;
            font-family: 'Dalek';
            font-size: 4vw;
            text-align: center;
            text-shadow:-3px 4px 1px #be8f57;
        }

        .button {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 60px;
            background-color: var(--color-primary);
            color: var(--color-fg);
            text-decoration: none;
            font-family: 'Lato', sans-serif;
            font-weight: bold;
            border-radius: 20px;
            font-size: var(--font-medium);
            border-bottom: 1px solid white;
            transition: all 0.3s;
            text-transform: uppercase;
        }

        .button:hover {
            background-color: var(--color-primary-dark);
        }

        @media (max-width: 900px) {
            :root{
                --competitions-title: 40%;
                --guidebook-title: 25%;
            }
            h1{
                font-size: 5.5vw;
                text-shadow:-3px 2px #be8f57;
            }
        }

        @media (max-width: 768px) {
            :root{
                --competitions-title: 40%;
                --guidebook-title: 25%;
            }
            h1 {
                font-size: 6vw;
                text-shadow:-2px 1px #be8f57;
            }

            .box-container {
                width: 90%;
            }

            .button {
                padding: 8px 40px;
                font-size: var(--font-medium);
            }
        }

        @media (max-width: 480px) {
            :root{
                --competitions-title: 40%;
                --guidebook-title: 25%;
            }
            h1 {
                font-size: 8vw;
                text-shadow:-2px 1px #be8f57;
            }

            .box-container {
                width: 100%;
            }

            .button {
                padding: 6px 30px;
                font-size: var(--font-small);
            }
        }

        .bird {
            position: absolute;
            z-index: 1;
            width: 250px;
        }

        .bird-right-1 {
            top: 18%;
            right: -115px;
            transform: rotate(180deg);
        }

        .bird-left-1 {
            top: 30%;
            left: -115px;
        }

        .bird-right-2 {
            bottom: 26%;
            right: -115px;
            transform: rotate(180deg);
        }

        @media screen and (max-width: 768px){
            :root{
                --competitions-title: 40%;
                --guidebook-title: 25%;
            }
            .bird {
                width: 120px;
                z-index: -1;
            }

            .bird-right-1 {
                top: 18%;
                right: -60px;
            }

            .bird-left-1 {
                top: 30%;
                left: -60px;
            }

            .bird-right-2 {
                bottom: 26%;
                right: -60px;
            }
        }

        .competitions-title {
            width: var(--competitions-title);
        }

        .guidebook-title {
            width: var(--guidebook-title);
        }
    </style>
@endsection

@section('content')
<div class="container-fluid overflow-x-hidden">
    <div class="container py-5 d-flex align-items-center flex-column">
        <img src="{{ asset('asset2026/COMPETITION BOARD/competitions.webp') }}" alt="competitions-title" class="competitions-title mb-4">
        <br>
        <div class="box-container">
            <div data-aos="fade-up" data-aos-delay="100">
                @foreach (['PENYISIHAN', 'SEMIFINAL', 'FINAL'] as $section)
                    <div class="sub fs-2">{{ $section }}</div>
                    <div class="text fs-6 fw-normal">
                        @if ($section == 'PENYISIHAN')
                        Babak Penyisihan MANIAC XV berupa pengumpulan proposal dan link prototype dari design UI/UX. Peserta akan diberikan waktu hingga tanggal 21 Juli 2026 untuk membuat proposal karya dan prototype yang akan dilombakan sesuai dengan tema dan studi kasus yang diberikan oleh panitia. Setelah itu, peserta harus mengumpulkan hasil kerja mereka ke tempat pengumpulan yang sudah disediakan oleh panitia. Hasil akhir yang sudah dikumpulkan tidak dapat diubah.
                        @elseif ($section == 'SEMIFINAL')
                            Babak Semifinal MANIAC XV akan diadakan di Fakultas Teknik Universitas Surabaya. Babak ini akan terdiri dari Rally Games dan Game Besar yang wajib diikuti oleh setiap tim. Pada Rally Games akan terdapat pos-pos permainan yang harus diselesaikan dengan strategi dan kerja sama tim. Terdapat pula pos yang berisi pertanyaan teori mengenai User Interface, User Experience dan multimedia dasar, serta pertanyaan umum dan juga pos yang menguji kerja sama tim. Pada Game Besar, setiap tim akan bermain dan berkompetisi untuk memenangkan permainan.
                        @else
                            Babak final MANIAC XV akan diadakan secara on-site di Universitas Surabaya. Topik yang akan dilombakan pada babak final adalah User Interface Design dan User Experience Design.
                            <br><br>
                            User Interface Design adalah cabang lomba untuk membuat sebuah desain antarmuka untuk sebuah aplikasi. Peserta diharapkan dapat membuat desain antarmuka yang sesuai dengan salah satu contoh studi kasus.
                            <br>
                            User Experience Design adalah cabang lomba untuk mendesain pengalaman yang baik untuk user untuk aplikasi yang dibuat. Peserta diharapkan dapat mendesain User Experience semenarik mungkin sesuai dengan alur dan konsep yang telah dibuat.
                            <br><br>
                            Setiap tim akan mempresentasikan hasil kerjanya pada Babak Final. Peserta harus bisa memberikan penjelasan mengenai User Interface dan User Experience yang menarik dan kreatif sesuai dengan studi kasus yang telah ditentukan.
                        @endif
                    </div>
                    <br>
                @endforeach
            </div>
        </div>
        <br>

<div class="d-flex flex-column align-items-center mb-2">
    <img src="{{ asset('asset2026/COMPETITION BOARD/guidebook.webp') }}" alt="guidebook-title" class="guidebook-title mb-4">
    <br>
    <a href="https://bit.ly/GuidebookMANIACXV" target="_blank">
        <button class="button btn-lg">
            Guide Book Maniac XV
        </button>
    </a>
</div>

    </div>
</div>
@endsection
