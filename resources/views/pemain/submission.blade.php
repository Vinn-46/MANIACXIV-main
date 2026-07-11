@extends('pemain.layout.layout', ['title' => 'Submission'])

@section('cdn')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" integrity="sha512-7eHRwcbYkK4d9g/6tD/mhkf++eoTHwpNM9woBxtPUBWm67zeAfFC+HrdoE2GanKeocly/VxeLvIqwvCdk7qScg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js" integrity="sha512-onMTRKJBKz8M1TnqqDuGBlowlH0ohFzMXYRNebz+yOcc5TQr/zAKsthzhuv0hiyUKEiQEQXEynnXCvNTOk50dg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection

@section('styles')
    <style>
        .c-container{
            width: 100vw;
            height: 100vh;
        }
    </style>
@endsection

@section('content')
    {{--  Container  --}}
    <div class="c-container w-full max-w-7xl relative">
        <div class="bg-orange-50/90 mb-10 p-8 rounded flex flex-col gap-2 justify-between text-center">
            <h1 class="text-4xl mb-2 text-dark-brown font-bold">{{ $contest->name }}</h1>
            <h2 class="text-xl font-bold text-accent">Batas Waktu Pengumpulan</h2>
            <h2 class="text-2xl md:text-3xl font-extrabold text-red-600">{{ \Illuminate\Support\Carbon::createFromFormat('Y-m-d H:i:s', \Illuminate\Support\Carbon::parse($contest->close_date)->subMinute(30), 'Asia/Jakarta')->format('d F Y g:i A') }}</h2>
        </div>
        <div class="card rounded-lg shadow-md data z-[9]">
            {{--  Header  --}}
            <div class="flex items-center text-xl bg-[#8B181B] text-white p-5 font-medium rounded-t-lg gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 inline-block">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                </svg>
                <h1 class="font-bold">
                    Submission
                </h1>
            </div>

            {{--  Form  --}}
            <div class="card-body bg-[#FBF5E5] rounded-b-lg">
                @if($isSubmit)
                    <div class="badge badge-lg font-medium bg-green-100 text-green-900 border-green-500">
                        Submitted
                    </div>
                @else
                    <div class="badge badge-lg font-medium bg-red-100 text-red-900 border-red-500">
                        Unsubmitted
                    </div>
                @endif
                <div role="alert" class="alert alert-info rounded-md py-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-info-content shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>Silahkan masukkan link Google Drive berisi proposal dan file asset (Opsional)</span>
                </div>
                @if(session()->has('success'))
                    <div role="alert" class="alert alert-success rounded-md py-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span class="">{{ session()->get('success') }}</span>
                    </div>
                @endif
                @error('link')
                <div role="alert" class="alert alert-error mb-3 rounded-md">
                    <div class="flex flex-row justify-start items-center gap-x-2 w-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span><strong>{{ $message }}</strong></span>
                    </div>
                </div>
                @enderror
                <form action="{{ route('team.contest.submit', $contest) }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 mt-8 gap-2 lg:gap-12">
                    @csrf
                    <label class="form-control w-full lg:col-span-2">
                        <input type="text" placeholder="Link GDrive PDF" class="input input-bordered rounded-md w-full" name="link" />
                    </label>
                    <button type="submit" class="btn bg-[#847E31] hover:bg-[#733B2] w-full rounded-md lg:col-span-1 text-white">{{ $isSubmit ? "Resubmit" : "Submit" }}</button>
                </form>
                @if($isSubmit)
                    <div>
                        <a class="btn btn-sm bg-[#847E31] hover:bg-[#733B2] px-12 rounded text-white" target="_blank" href="{{ $link }}">Lihat Submission</a>
                    </div>
                @endif
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
