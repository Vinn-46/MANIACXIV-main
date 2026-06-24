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
            <div>
                <h1 class="text-5xl font-['dalek'] text-[#733b22]" style="text-shadow: -3px 2px 0px #be8f57">SHOP</h1>
                <h2 id="team-name-display" class="text-2xl font-['Lato'] font-bold text-[#733b22] mt-2 bg-[#dba668] inline-block px-4 py-1 rounded-lg shadow-inner hidden"></h2>
            </div>
            <div class="flex gap-2">
                <button onclick="openArena()" class="bg-[#733b22] hover:bg-[#5c2f1a] text-white border-2 border-[#dba668] px-6 py-2 rounded-full font-['Lato'] font-bold text-lg shadow-md transition-colors">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Target Base
                </button>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-full font-['Lato'] font-bold text-lg shadow-md transition-colors border-2 border-red-800">
                        <i class="fa-solid fa-right-from-bracket mr-2"></i> Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Player Selection (Hidden as requested, team selected via URL) -->
        <div class="hidden">
            <select id="pID">
                <option selected disabled value="">-- Silakan Pilih Player --</option>
                @foreach ($players as $p)
                    <option value="{{ $p->id }}">{{ $p->team_name }}</option>
                @endforeach 
            </select>
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
                <span class="text-xl font-['Lato'] font-bold uppercase mb-2">Nama Senjata</span>
                <span class="text-3xl font-extrabold" id="display-weapon">-</span>
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
                    </div>

                    <div class="bg-black/40 rounded-xl p-4 flex flex-col xl:flex-row items-center justify-between gap-4 mb-6 mt-4">
                        <div class="text-center w-full xl:w-5/12 flex flex-col justify-center">
                            <span class="text-sm font-semibold opacity-70 mb-1 block">Saat Ini</span>
                            <span class="text-xl font-extrabold uppercase" id="current-weapon-label">-</span>
                        </div>
                        
                        <div class="hidden xl:flex justify-center items-center w-2/12">
                            <i class="fa-solid fa-angles-right text-[#dba668] text-2xl opacity-70"></i>
                        </div>

                        <div class="text-center w-full xl:w-5/12 flex flex-col justify-center" id="next-weapon-box">
                            <span class="text-sm font-semibold opacity-70 mb-1 block" id="next-weapon-subtitle">Selanjutnya</span>
                            <span class="text-xl font-extrabold text-green-400 uppercase" id="next-weapon-label">-</span>
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
    let currentWeaponLevel = 1;

    const weaponNames = {
        1: "Peacemaker",
        2: "Sharpshooter",
        3: "Eagle Eye"
    };

    $(document).ready(function() {
        const urlParams = new URLSearchParams(window.location.search);
        const teamId = urlParams.get('team_id');
        if (teamId) {
            selPlayer.val(teamId).trigger('change');
            const teamName = selPlayer.find('option:selected').text();
            $('#team-name-display').text($.trim(teamName)).removeClass('hidden');
        }
    });

    function openArena() {
        const teamId = selPlayer.val();
        let url = "{{ route('si.index') }}";
        if (teamId) {
            url += "?team_id=" + teamId;
        }
        window.location.href = url;
    }

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
        currentWeaponLevel = wLevel;
        displayWeapon.text(weaponNames[wLevel]);
    }

    function updateUpgradeUI(wLevel) {
        labelCurrentW.text(weaponNames[wLevel]);
        
        if (wLevel == 1) {
            $('#next-weapon-subtitle').show();
            labelNextW.show().text("Sharpshooter").removeClass('text-red-400 text-2xl').addClass('text-green-400 text-xl tracking-normal uppercase');
            boxCostW.show();
            textCostW.text("600 Honor");
            btnUpgrade.prop('disabled', false).text("UPGRADE SENJATA");
        } else if (wLevel == 2) {
            $('#next-weapon-subtitle').show();
            labelNextW.show().text("Eagle Eye").removeClass('text-red-400 text-2xl').addClass('text-green-400 text-xl tracking-normal uppercase');
            boxCostW.show();
            textCostW.text("1200 Honor");
            btnUpgrade.prop('disabled', false).text("UPGRADE SENJATA");
        } else {
            $('#next-weapon-subtitle').hide();
            labelNextW.show().text("MAX").removeClass('text-green-400 text-xl').addClass('text-red-400 text-2xl tracking-widest uppercase');
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
                            updateUIResources(res.new_honor, res.new_peluru, currentWeaponLevel);
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
