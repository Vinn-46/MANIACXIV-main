@extends("si.layout.app")

@section("style")
    <style>
        :root{
            --c1: #733B22; 
        }
        .resource-card {
            background: rgba(229, 209, 184, 0.9);
            border: 4px solid #ae8350;
            border-bottom-color: #8b5f1e;
            border-right-color: #8b5f1e;
        }
        .shop-card {
            background: rgba(110, 72, 26, 0.95);
            border: 4px solid #dba668;
            color: #e5d1b8;
        }
    </style>
@endsection

@section("content")
    <div class="c-bg-white shadow-lg p-6 rounded-lg w-full max-w-[80vw] mx-auto min-h-[80vh] flex flex-col relative">
        
        <!-- Header & Nav -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-5xl font-['dalek'] text-[#733b22]" style="text-shadow: -3px 2px 0px #be8f57">BLACK MARKET</h1>
            <button onclick="window.location.href='{{ route('si.index') }}'" class="bg-[#733b22] hover:bg-[#5a2e1a] text-white px-6 py-2 rounded-full font-['Lato'] font-bold text-lg shadow-md transition-colors">
                <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Beranda
            </button>
        </div>

        <!-- Player Selection -->
        <div class="bg-gradient-to-r from-[#dba668] to-[#be8f57] p-6 rounded-2xl mb-8 flex flex-col md:flex-row items-center justify-between shadow-xl border-4 border-[#733b22] gap-4">
            <div class="flex items-center whitespace-nowrap">
                <span class="text-[#733b22] font-['Lato'] font-extrabold text-2xl uppercase tracking-wider">Pilih Tim :</span>
            </div>
            
            <div class="w-full md:w-1/2 flex-grow">
                <select id="pID" class="w-full py-4 px-6 rounded-xl text-xl font-['Lato'] font-bold shadow-inner text-[#733b22] border-4 border-[#733b22] bg-[#f0e9cf] focus:outline-none focus:ring-4 focus:ring-[#733b22] cursor-pointer appearance-none" name="state" style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23733B22%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 1rem top 50%; background-size: 1.5rem auto;">
                    <option selected disabled value="">-- Silakan Pilih Player --</option>
                    @foreach ($players as $p)
                        <option value="{{ $p->id }}">
                            {{ $p->team_name }}
                        </option>
                    @endforeach 
                </select>
            </div>

            <div class="whitespace-nowrap min-w-[180px] text-center">
                <span id="loading-indicator" class="text-white font-bold hidden bg-black/40 px-4 py-3 rounded-lg text-lg"><i class="fa-solid fa-spinner fa-spin mr-2"></i> Memuat...</span>
                <span id="ready-indicator" class="text-white font-bold bg-green-600/80 px-4 py-3 rounded-lg text-lg border-2 border-green-400 hidden"><i class="fa-solid fa-check mr-2"></i> Siap!</span>
            </div>
        </div>

        <!-- Resource Stats -->
        <div class="grid grid-cols-3 gap-6 mb-8">
            <div class="resource-card p-4 rounded-xl flex flex-col items-center justify-center text-[#733b22] shadow-lg h-32">
                <span class="text-xl font-['Lato'] font-bold uppercase mb-2">Total Honor</span>
                <span class="text-4xl font-extrabold" id="display-honor">-</span>
            </div>
            <div class="resource-card p-4 rounded-xl flex flex-col items-center justify-center text-[#733b22] shadow-lg h-32">
                <span class="text-xl font-['Lato'] font-bold uppercase mb-2">Amunisi Peluru</span>
                <span class="text-4xl font-extrabold" id="display-peluru">-</span>
            </div>
            <div class="resource-card p-4 rounded-xl flex flex-col items-center justify-center text-[#733b22] shadow-lg h-32">
                <span class="text-xl font-['Lato'] font-bold uppercase mb-2">Level Senjata</span>
                <span class="text-4xl font-extrabold" id="display-weapon">-</span>
            </div>
        </div>

        <!-- Actions -->
        <div class="grid grid-cols-2 gap-8 flex-grow">
            <!-- Buy Peluru -->
            <div class="shop-card rounded-2xl p-6 shadow-2xl flex flex-col justify-between">
                <div>
                    <div class="flex justify-between items-center border-b-2 border-[#dba668] pb-4 mb-4">
                        <h2 class="text-3xl font-['Lato'] font-bold">Beli Peluru</h2>
                        <span class="bg-[#dba668] text-[#733b22] px-3 py-1 rounded font-bold">1 = 100 Honor</span>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-lg font-['Lato'] mb-2 font-semibold">Jumlah Peluru</label>
                        <input type="number" id="peluru-amount" min="1" value="1" disabled
                            class="w-full text-2xl font-bold text-center text-black py-2 rounded focus:outline-none focus:ring-4 focus:ring-[#dba668]">
                    </div>

                    <div class="bg-black/40 rounded p-4 flex justify-between items-center mb-6">
                        <span class="text-xl font-bold">Total Harga:</span>
                        <span class="text-3xl font-extrabold text-[#facc15]" id="peluru-cost">100 Honor</span>
                    </div>
                </div>
                
                <button id="btn-buy-peluru" disabled class="bg-green-600 hover:bg-green-500 disabled:bg-gray-500 text-white w-full py-4 rounded-xl font-['Lato'] font-bold text-2xl shadow-lg transition-all active:scale-95">
                    BELI SEKARANG
                </button>
            </div>

            <!-- Upgrade Weapon -->
            <div class="shop-card rounded-2xl p-6 shadow-2xl flex flex-col justify-between">
                <div>
                    <div class="flex justify-between items-center border-b-2 border-[#dba668] pb-4 mb-4">
                        <h2 class="text-3xl font-['Lato'] font-bold">Upgrade Senjata</h2>
                        <span class="bg-[#dba668] text-[#733b22] px-3 py-1 rounded font-bold">Max LV. 3</span>
                    </div>

                    <div class="bg-black/40 rounded-xl p-6 flex flex-row items-end justify-between px-16 mb-6 mt-4 h-32">
                        <div class="text-center flex flex-col items-center justify-end h-full">
                            <span class="text-sm font-semibold opacity-70 mb-2">Saat Ini</span>
                            <span class="text-5xl font-extrabold" id="current-weapon-label">LV. -</span>
                        </div>

                        <div class="text-center flex flex-col items-center justify-end h-full" id="next-weapon-box">
                            <span class="text-sm font-semibold opacity-70 mb-2" id="next-weapon-subtitle">Selanjutnya</span>
                            <span class="text-5xl font-extrabold text-green-400" id="next-weapon-label">LV. -</span>
                        </div>
                    </div>

                    <div class="bg-black/40 rounded p-4 flex justify-between items-center mb-6" id="upgrade-cost-box">
                        <span class="text-xl font-bold">Biaya Upgrade:</span>
                        <span class="text-3xl font-extrabold text-[#facc15]" id="upgrade-cost">- Honor</span>
                    </div>
                </div>
                
                <button id="btn-upgrade" disabled class="bg-blue-600 hover:bg-blue-500 disabled:bg-gray-500 text-white w-full py-4 rounded-xl font-['Lato'] font-bold text-2xl shadow-lg transition-all active:scale-95">
                    UPGRADE SENJATA
                </button>
            </div>
        </div>

    </div>
@endsection

@section("script")
<script>
    const selPlayer = $('#pID');
    const displayHonor = $('#display-honor');
    const displayPeluru = $('#display-peluru');
    const displayWeapon = $('#display-weapon');
    
    const inputPeluru = $('#peluru-amount');
    const textPeluruCost = $('#peluru-cost');
    const btnBuyPeluru = $('#btn-buy-peluru');

    const labelCurrentW = $('#current-weapon-label');
    const labelNextW = $('#next-weapon-label');
    const boxNextW = $('#next-weapon-box');
    const boxCostW = $('#upgrade-cost-box');
    const textCostW = $('#upgrade-cost');
    const btnUpgrade = $('#btn-upgrade');

    let currentHonorVal = 0;

    // Handle Player Selection
    selPlayer.on('change', function() {
        const playerId = $(this).val();
        if (!playerId) return;

        $('#loading-indicator').removeClass('hidden');
        $('#ready-indicator').addClass('hidden');
        disableAll();

        $.ajax({
            url: "{{ route('si.shop.playerDetails') }}",
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                player_id: playerId
            },
            success: function(res) {
                $('#loading-indicator').addClass('hidden');
                $('#ready-indicator').removeClass('hidden');
                updateUIResources(res.honor, res.peluru, res.weapon_level);
                enablePeluruInput();
                updateUpgradeUI(res.weapon_level);
            },
            error: function(err) {
                $('#loading-indicator').addClass('hidden');
                Swal.fire('Error', 'Gagal memuat data player.', 'error');
            }
        });
    });

    function disableAll() {
        inputPeluru.prop('disabled', true);
        btnBuyPeluru.prop('disabled', true);
        btnUpgrade.prop('disabled', true);
    }

    function enablePeluruInput() {
        inputPeluru.prop('disabled', false);
        btnBuyPeluru.prop('disabled', false);
        inputPeluru.val(1).trigger('input');
    }

    function updateUIResources(honor, peluru, wLevel) {
        currentHonorVal = honor;
        displayHonor.text(honor);
        displayPeluru.text(peluru);
        displayWeapon.text("LV. " + wLevel);
    }

    function updateUpgradeUI(wLevel) {
        labelCurrentW.text("LV. " + wLevel);
        
        if (wLevel == 1) {
            $('#next-weapon-subtitle').show();
            labelNextW.show().text("LV. 2").removeClass('text-red-400 text-3xl').addClass('text-green-400 text-5xl tracking-normal uppercase');
            boxCostW.show();
            textCostW.text("1500 Honor");
            btnUpgrade.prop('disabled', false).text("UPGRADE SENJATA");
        } else if (wLevel == 2) {
            $('#next-weapon-subtitle').show();
            labelNextW.show().text("LV. 3").removeClass('text-red-400 text-3xl').addClass('text-green-400 text-5xl tracking-normal uppercase');
            boxCostW.show();
            textCostW.text("3000 Honor");
            btnUpgrade.prop('disabled', false).text("UPGRADE SENJATA");
        } else {
            $('#next-weapon-subtitle').hide();
            labelNextW.show().text("MAX").removeClass('text-green-400 text-5xl').addClass('text-red-400 text-4xl tracking-widest uppercase');
            boxCostW.hide();
            btnUpgrade.prop('disabled', true).text("SENJATA MAKSIMAL");
        }
    }

    // Peluru Input Calculate
    inputPeluru.on('input', function() {
        let val = parseInt($(this).val());
        if (isNaN(val) || val < 1) val = 0;
        textPeluruCost.text((val * 100) + " Honor");
    });

    // Buy Peluru Action
    btnBuyPeluru.on('click', function() {
        const playerId = selPlayer.val();
        const amount = parseInt(inputPeluru.val());
        
        if (isNaN(amount) || amount < 1) {
            Swal.fire('Oops...', 'Masukkan jumlah peluru yang valid!', 'warning');
            return;
        }

        const cost = amount * 100;
        if (currentHonorVal < cost) {
            Swal.fire('Honor Tidak Cukup!', `Dibutuhkan ${cost} Honor, tapi saldo hanya ${currentHonorVal}.`, 'error');
            return;
        }

        Swal.fire({
            title: 'Konfirmasi Pembelian',
            html: `Beli <b>${amount} Peluru</b> seharga <b>${cost} Honor</b> untuk tim ini?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#16a34a',
            confirmButtonText: 'Ya, Beli!'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({ title: 'Memproses...', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); }});

                $.ajax({
                    url: "{{ route('si.shop.buyPeluru') }}",
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        player_id: playerId,
                        amount: amount
                    },
                    success: function(res) {
                        if (res.success) {
                            updateUIResources(res.new_honor, res.new_peluru, displayWeapon.text().replace("LV. ", ""));
                            Swal.fire('Berhasil!', res.message, 'success');
                            inputPeluru.val(1).trigger('input');
                        } else {
                            Swal.fire('Gagal', res.message, 'error');
                        }
                    },
                    error: function(err) {
                        let msg = err.responseJSON ? err.responseJSON.message : 'Terjadi kesalahan sistem.';
                        Swal.fire('Error', msg, 'error');
                    }
                });
            }
        });
    });

    // Upgrade Weapon Action
    btnUpgrade.on('click', function() {
        const playerId = selPlayer.val();
        const cost = parseInt(textCostW.text().replace(/\D/g, ''));

        if (currentHonorVal < cost) {
            Swal.fire('Honor Tidak Cukup!', `Dibutuhkan ${cost} Honor untuk upgrade.`, 'error');
            return;
        }

        Swal.fire({
            title: 'Konfirmasi Upgrade',
            html: `Upgrade senjata tim ini seharga <b>${cost} Honor</b>?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#2563eb',
            confirmButtonText: 'Ya, Upgrade!'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({ title: 'Memproses...', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); }});

                $.ajax({
                    url: "{{ route('si.shop.upgradeWeapon') }}",
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        player_id: playerId
                    },
                    success: function(res) {
                        if (res.success) {
                            updateUIResources(res.new_honor, displayPeluru.text(), res.new_weapon_level);
                            updateUpgradeUI(res.new_weapon_level);
                            Swal.fire('Berhasil!', res.message, 'success');
                        } else {
                            Swal.fire('Gagal', res.message, 'error');
                        }
                    },
                    error: function(err) {
                        let msg = err.responseJSON ? err.responseJSON.message : 'Terjadi kesalahan sistem.';
                        Swal.fire('Error', msg, 'error');
                    }
                });
            }
        });
    });
</script>
@endsection
