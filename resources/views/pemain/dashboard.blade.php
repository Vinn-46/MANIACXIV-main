@extends('pemain.layout.layout', ['title' => 'Dashboard'])
@section('cdn')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" integrity="sha512-7eHRwcbYkK4d9g/6tD/mhkf++eoTHwpNM9woBxtPUBWm67zeAfFC+HrdoE2GanKeocly/VxeLvIqwvCdk7qScg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js" integrity="sha512-onMTRKJBKz8M1TnqqDuGBlowlH0ohFzMXYRNebz+yOcc5TQr/zAKsthzhuv0hiyUKEiQEQXEynnXCvNTOk50dg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection

@section('styles')
    <style>
        @font-face {
            font-family: 'duality';
            src: url("{{ asset('fonts/duality/duality.otf') }}") format("opentype");
        }

        .font-duality {
            font-family: 'duality', sans-serif;
        }

        #decordDataTim {
            transform: scaleX(-1);
        }

        .action:hover {
            color: #E7EADF !important;
        }

    </style>
@endsection

@section('content')
<div class="grid grid-cols-1 gap-8 w-full max-w-7xl">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{--  Data Peserta  --}}
        <div class="bg-dark-red flex flex-col p-4 rounded-md shadow-md data relative">
            <h1 class="text-xl md:text-xl font-normal bg-white py-2 px-4 text-center text-[#3B1910] rounded-md uppercase font-duality">Data Peserta</h1>
            <div class="text-md md:text-xl bg-white py-2 px-4 rounded-md mt-4">
                <table class="table text-black font-semibold text-base" >
                    <tbody>
                        @foreach($participants as $participant)
                            <tr>
                                <td class="p-0">Nama</td>
                                <td class="p-0">:</td>
                                <td class="break-words">{{ $participant->name }}</td>
                            </tr>
                            <tr>
                                <td class="p-0">Email</td>
                                <td class="p-0">:</td>
                                <td class="break-words">{{ $participant->email }}</td>
                            </tr>
                            <tr>
                                <td class="p-0">Posisi</td>
                                <td class="p-0">:</td>
                                @php($pos = ($participant->position == 'leader') ? 'ketua' : 'anggota')
                                <td class="break-words">
                                    <span class="badge badge-md rounded-lg text-slate-900 {{ $pos == 'ketua' ? 'badge-success text-white' : 'badge-warning ' }} font-semibold">{{ $pos }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" class="p-0">
                                    <div class="w-full divider"></div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{--  Data Team  --}}
        <div class="bg-dark-red flex flex-col p-4 rounded-md shadow-md data relative">
            <h1 class="text-xl md:text-xl font-normal bg-white py-2 px-4 text-center text-[#3B1910] rounded-md uppercase font-duality">Data Tim</h1>
            <div class="text-md md:text-xl bg-white py-2 px-4 rounded-md mt-4 h-full">
                <table class="table text-black font-semibold text-base" >
                    <tbody>
                    <tr>
                        <td class="p-0">Nama Tim</td>
                        <td class="p-0">:</td>
                        <td class="break-words">{{ $team->name }}</td>
                    </tr>
                    <tr>
                        <td class="p-0">Nama Sekolah</td>
                        <td class="p-0">:</td>
                        <td class="break-words">{{ $team->school_name }}</td>
                    </tr>
                    <tr>
                        <td class="p-0">Alamat Sekolah</td>
                        <td class="p-0">:</td>
                        <td class="break-all">{{ $team->school_address }}</td>
                    </tr>
                    <tr>
                        <td class="p-0">Nomor Sekolah</td>
                        <td class="p-0">:</td>
                        <td class="break-words">{{ $team->school_number }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 gap-8">
        {{--  Timeline  --}}
        <div class="bg-dark-red flex flex-col p-4 rounded-md w-full shadow-md data">
            <h1 class="text-xl md:text-xl font-normal bg-white py-2 px-4 text-center text-[#3B1910] rounded-md uppercase font-duality">Timeline</h1>
            <div class="text-md md:text-xl bg-white py-4 px-4 rounded-md mt-4 h-full">
                <img src="{{ asset('asset2026') }}/home/Timeline.webp" alt="Timeline maniac 2026" draggable="false">
            </div>
        </div>

        {{--  Instruksi Penggunaan  --}}
        <div class="bg-dark-red flex flex-col p-4 rounded-md w-full shadow-md data relative">
            <h1 class="text-xl md:text-xl font-normal bg-white py-4 px-4 text-center text-[#3B1910] rounded-md uppercase font-duality">Instruksi Penggunaan</h1>
            <div class="text-md md:text-xl bg-white max-md:py-1 max-md:px-4 md:py-2 md:px-8 rounded-md mt-4 h-full">
                <div class="flex flex-col gap-3 text-black">
                    {{--
                    <div class="badge badge-accent rounded-md text-sm text-bone mt-6 p-4 font-semibold">6 Mei 2025</div> --}}
                    <div class="divider"></div>
                    <div>
                        <p class="p-0 pb-2 m-o font-bold">Akun</p>
                        <p class="p-0 m-0 font-medium">Setiap akun hanya bisa login di satu komputer. Apabila login lebih dari satu komputer, maka akun yang login pertama otomatis logout.</p>
                    </div>
                    <div class="divider"></div>
                    <div>
                        <p class="p-0 pb-2 m-o font-bold">Browser</p>
                        <p class="p-0 m-0 font-medium">Disarankan menggunakan web browser Chrome dan TIDAK disarankan menggunakan web browser Safari dalam penggunaan web ini.</p>
                    </div>
                    <div class="divider"></div>
                    <div>
                        <p class="p-0 pb-2 m-o font-bold">Contest</p>
                        <p class="p-0 m-0 font-medium">Menu <strong>Contest</strong> digunakan untuk mengumpulkan tugas Workshop berupa link Google Drive dari <strong class="text-bold">File</strong> (<strong class="text-bold text-red-600">BUKAN FOLDER</strong>) yang akan dikumpulkan berupa <strong>PDF</strong>.</p>
                    </div>
                    <div class="divider"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        const datas = gsap.utils.toArray('.data');
        datas.forEach(data => {
            const anim = gsap.fromTo(
                data,
                {
                    autoAlpha: 0,
                    y: 100,
                },
                {
                    duration: 0.6,
                    autoAlpha: 1,
                    y: 0,
                    x: 0,
                }
            );
            ScrollTrigger.create({
                trigger: data,
                animation: anim,
            });
        });
    </script>
@endsection
