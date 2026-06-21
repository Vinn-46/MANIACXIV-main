@extends("si.layout.app")

@section("style")
    <style>
        :root{
            --c1: #733B22; 
        }
    </style>
@endsection

@section("content")
    <div class="c-bg-white shadow-2xl p-10 rounded-2xl max-w-[60vw] w-full text-center border-4 border-[#8b181b]">
        <h1 class="text-6xl font-['dalek'] text-[#8b181b] mb-2 drop-shadow-md" style="text-shadow: -3px 2px 0px #8b181b">PANEL GAME BESAR</h1>
        <p class="text-2xl font-['Lato'] font-bold text-[#733b22] mb-10 opacity-90">Sistem Informasi (SI) Dashboard</p>

        <div class="grid grid-cols-2 gap-10">
            <!-- Tombol Shop -->
            <button onclick="window.location.href='{{ route('si.shop.index') }}'" class="bg-gradient-to-b from-[#e5d1b8] to-[#dba668] hover:from-[#dba668] hover:to-[#be8f57] border-4 border-[#733b22] rounded-3xl p-8 shadow-xl transition-all hover:-translate-y-2 group flex flex-col items-center justify-center">
                <i class="fa-solid fa-store text-7xl text-[#733b22] mb-6 group-hover:scale-110 transition-transform drop-shadow-md"></i>
                <h2 class="text-3xl font-['Lato'] font-extrabold text-[#733b22] tracking-wider">SHOP</h2>
                <p class="text-[#733b22] font-semibold mt-2 text-lg">Beli Peluru & Upgrade Senjata</p>
            </button>

            <!-- Tombol Target Base -->
            <button onclick="window.location.href='{{ route('si.targetBase.index') }}'" class="bg-gradient-to-b from-[#e5d1b8] to-[#dba668] hover:from-[#dba668] hover:to-[#be8f57] border-4 border-[#733b22] rounded-3xl p-8 shadow-xl transition-all hover:-translate-y-2 group flex flex-col items-center justify-center relative overflow-hidden">
                <i class="fa-solid fa-bullseye text-7xl text-[#733b22] mb-6 group-hover:scale-110 transition-transform drop-shadow-md"></i>
                <h2 class="text-3xl font-['Lato'] font-extrabold text-[#733b22] tracking-wider">TARGET BASE</h2>
                <p class="text-[#733b22] font-semibold mt-2 text-lg">Sistem Penyerangan Pos</p>
            </button>
        </div>
    </div>
@endsection

@section("script")
@endsection