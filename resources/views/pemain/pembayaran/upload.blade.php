@extends('pemain.pembayaran.layout', ["title" => "Upload Bukti Pembayaran", "head   ing" => "Upload Bukti Pembayaran"])

@section('styles')
    <style>
        li:hover {
            cursor: url("{{ asset('asset2026/cursor/cursor.png') }}"), default !important;
        }
    </style>
@endsection

@section("content")
    <h2 class="pt-3 sm:pb-0 text-xl font-semibold">Petunjuk Pembayaran</h2>
    <div class="divider my-0 before:bg-[#8E5324] after:bg-[#8E5324]"></div>
    <p class="text-red-600 font-bold">Transfer melalui rekening BCA: 0880641581 a/n FERNANDA EVANGELINE</p>
    <p>Biaya Pendaftaran:</p>
    <table class="table">
        <thead class="bg-[#8E5324] text-neutral-content text-center">
            <tr>
                <th width="50%">Batch</th>
                <th width="50%">Biaya</th>
            </tr>
        </thead>
        <tbody class="text-center">
            <tr class="border-[#8E5324]">
                <td width="50%" class="font-medium">Batch Early Bird (11 Mei 2026 s/d 2 Juni 2026)</td>
                <td width="50%">Rp. 40.000/tim</td>
            </tr>
            <tr class="border-[#8E5324]">
                <td width="50%" class="font-medium">Batch Normal (3 Juni 2026 s/d 17 Juli 2026)</td>
                <td width="50%">Rp. 65.000/tim</td>
            </tr>
        </tbody>
    </table>
    <div role="alert" class="alert alert-warning bg-[#E5C741] border-none text-black">
        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
        <span class="text-justify">Jika pada <strong>Batch Normal</strong> Mendaftar 3 tim atau lebih secara langsung (berasal dari sekolah yang SAMA), akan mendapatkan potongan harga menjadi Rp. 40.000/tim</span>
    </div>
    <div class="divider my-0 before:bg-[#8E5324] after:bg-[#8E5324]"></div>
    <p class="font-bold text-lg">Ketentuan Transfer</p>
    <p>Bagi sekolah yang mendaftarkan 3 tim atau lebih pada <strong>Batch Normal</strong></p>
    <ul class="list-disc list-outside pl-5">
        <li class="mb-3 md:mb-0">Wajib transfer menggunakan <strong>1 rekening</strong> yang sama dalam 1x transfer dan mencantumkan nama tiap tim dan sekolah pada berita pembayaran.</li>
        <li class="mb-3 md:mb-0">Total Biaya pendaftaran: <strong>Rp. 40.000 x jumlah tim</strong> yang mendaftar.</li>
        <li>Setelah mengupload bukti transfer harap <strong>mengkonfirmasi</strong> ke contact person Whatsapp <a target="_blank" href="https://wa.me/+6285330001180" style="cursor: pointer !important;" class="font-bold">Nadya Putri Ramadhani (082232958165)</a></li>
    </ul>
    <div class="divider my-0 before:bg-[#8E5324] after:bg-[#8E5324]"></div>
    @error('bukti_pembayaran')
    <div role="alert" class="alert alert-error">
        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        <span>{{ $message }}</span>
    </div>
    @enderror
    <form action="{{ route('team.pembayaran.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label class="form-control w-full">
            <div class="label">
                <span class="label-text font-medium">Foto Bukti Pembayaran (max: <strong>10MB</strong>, type: png/jpeg/jpg)</span>
            </div>
            <input type="file" class="file-input file-input-bordered w-full max-w-md file:bg-[#847E31] file:text-white file:border-none hover:file:bg-[#736e2a]" name="bukti_pembayaran" id="bukti_pembayaran" accept="image/png, image/jpg, image/jpeg"/>
        </label>
        <div class="flex justify-center items-center w-full">
            <img src="" alt="" class="w-1/2 lg:w-2/6 pt-2" id="fotoPembayaran">
        </div>
        <div class="modal-action">
            <button class="btn bg-[#847E31] text-white border-none hover:bg-[#847E31]/80 px-8" type="button" onclick="modalKonfirm.showModal()">Next</button>
        </div>
        <dialog id="modalKonfirm" class="modal modal-bottom sm:modal-middle">
            <div class="modal-box">
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" type="button" onclick="modalKonfirm.close()">✕</button>
                </form>
                <h3 class="font-bold text-2xl text-center">Validasi Data</h3>
                <p class="pt-5">Apakah bukti pembayaran yang anda masukkan sudah benar?</p>
                <p class="pb-2 font-semibold text-red-500">Data yang telah diinput, tidak dapat diganti</p>
                <div class="modal-action">
                    <button class="btn bg-[#847E31] px-8">Ya</button>
                </div>
            </div>
        </dialog>
    </form>
@endsection

@section('scripts')
    <script>
         const img = document.getElementById('fotoPembayaran');
         const inputImg = document.getElementById('bukti_pembayaran');

         inputImg.addEventListener('change', (e) => {
             img.src = URL.createObjectURL(e.target.files[0]);
         })
    </script>
@endsection
