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

        .image-container {
            background-image: url("{{ asset('asset2026/Target Base/papan.webp') }}");
            width: 325px;
            height: 132px;
        }
    </style>
@endsection

@section("content")
<div class="max-w-[1300px] w-[85vw] h-[80vh] max-h-[900px] mx-auto font-['Creato Display'] flex flex-col box-border">
     <div class="w-full flex flex-row justify-center items-stretch gap-4 mb-6">
        <div class="flex-1"></div>
        <div class="flex flex-row px-10 py-3 gap-2 rounded-full text-lg text-white font-bold bg-[#8b181b]">
            <button class="px-5 py-2 rounded-full {{ request()->routeIs('si.index') ? 'bg-white text-[#8b181b]' : 'text-white' }}" onclick="openTab('{{ route('si.index') }}')">TARGET BASE</button>
            <button id="nav-shop" class="px-5 py-2 rounded-full {{ request()->routeIs('si.shop.index') ? 'bg-white text-[#8b181b]' : 'text-white' }}">SHOP</button>
        </div>
        <form method="POST" action="{{ route('logout') }}" class="flex flex-1 justify-end">
            @csrf
            <button type="submit" class="bg-white hover:bg-[#f3f3f3] text-[#8b181b] px-6 py-2 rounded-full text-lg font-bold shadow-md transition-colors">
                <i class="fa-solid fa-right-from-bracket mr-2"></i> LOGOUT
            </button>
        </form>
    </div>

    <div class="c-bg-white shadow-lg p-12 rounded-[36px] flex flex-col grow gap-10">
        <!-- Player Selection -->
        <div class="rounded-2xl flex flex-col md:flex-row items-center justify-between gap-4">
            <div id="team-name-display" class="flex items-center px-6 py-2 rounded-full uppercase text-lg text-white font-bold bg-[#8b181b]">
                TEAM NAME
            </div>
        </div>

        <!-- Player Selection (Hidden as requested, team selected via URL) -->
        <div class="hidden">
            <select disabled id="pID" class="text-lg font-bold">
                <option selected disabled value="">-- Silakan Pilih Player --</option>
                @foreach ($players as $p)
                    <option value="{{ $p->id }}">{{ $p->team_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex flex-row justify-between gap-12">
            <div class="image-container flex flex-col justify-center items-center text-white">
                <span class="text-xl font-bold uppercase mb-2">Total Honor</span>
                <span class="text-4xl font-extrabold" id="display-honor">-</span>
            </div>
            <div class="image-container flex flex-col justify-center items-center text-white">
                <span class="text-xl font-bold uppercase mb-2">Amunisi Peluru</span>
                <span class="text-4xl font-extrabold" id="display-peluru">-</span>
            </div>
            <div class="image-container flex flex-col justify-center items-center text-white">
                <span class="text-xl font-bold uppercase mb-2">Nama Senjata</span>
                <span class="text-3xl font-extrabold" id="display-weapon">-</span>
            </div>
        </div>

        <!-- Actions -->
        <div class="grid grid-cols-2 gap-8 flex-grow">
            <!-- Buy Peluru -->
            <div class="flex flex-col bg-[#fbf5e5] rounded-[24px] border-2 border-[#8b181b] overflow-hidden">
                <div class="flex justify-between items-center p-4 bg-[#8b181b]">
                    <h2 class="text-white text-xl font-bold">Beli Peluru</h2>
                    <span class="px-3 py-1 rounded-full font-bold bg-white text-[#8b181b]">1 = 100 HONOR</span>
                </div>

                <div class="h-full flex flex-col justify-between gap-36 px-5 pt-5 pb-8">
                    <div class="flex flex-col gap-4">
                        <div class="flex flex-col gap-2">
                            <label class="text-md text-[#8b181b] font-semibold">Jumlah Peluru</label>
                            <input type="number" id="peluru-amount" min="1" value="1" disabled
                                class="w-full rounded-lg text-center text-lg text-white font-bold bg-[#b3ae6b] border-none">
                        </div>
                        <div class="flex flex-row justify-between items-center px-4 py-2 rounded-lg bg-[#847e31] text-white">
                            <span class="text-lg font-bold">Total Harga:</span>
                            <span class="text-lg font-bold" id="peluru-cost">100 Honor</span>
                        </div>
                    </div>

                    <button id="btn-buy-peluru" disabled class="self-center px-12 py-2 rounded-lg bg-[#847e31] hover:brightness-90 disabled:brightness-50 text-white font-bold text-lg shadow-lg transition-all active:scale-95">
                        Beli Sekarang
                    </button>
                </div>
            </div>

            <!-- Upgrade Weapon -->
            <div class="flex flex-col bg-[#fbf5e5] rounded-[24px] border-2 border-[#8b181b] overflow-hidden">
                <div class="flex justify-between items-center p-4  bg-[#8b181b]">
                    <h2 class="text-white text-xl font-bold">Upgrade Senjata</h2>
                    <span class="px-3 py-1 rounded-full font-bold bg-white text-[#8b181b]">Max Level 3</span>
                </div>

                <div class="h-full flex flex-col  justify-between gap-4 px-5 pt-5 pb-8">
                    <div class="flex flex-col gap-4">
                        <div class="w-full flex flex-row justify-evenly gap-4 px-8 py-4 rounded-lg  text-white bg-[#b3ae6b]">
                            <div class="flex flex-col text-center">
                                <span class="font-medium">Saat Ini</span>
                                <span id="current-weapon-label" class="text-2xl font-extrabold">-</span>
                            </div>

                            <div class="hidden xl:flex justify-center items-center w-2/12">
                                <i class="fa-solid fa-angles-right text-white text-2xl opacity-70"></i>
                            </div>

                            <div class="flex flex-col text-center">
                                <span class="font-medium">Selanjutnya</span>
                                <span id="next-weapon-label" class="text-2xl font-extrabold">-</span>
                            </div>
                        </div>
                        <div class="flex flex-row justify-between items-center px-4 py-2 rounded-lg bg-[#847e31] text-white">
                            <span class="text-lg font-bold">Total Harga:</span>
                            <span class="text-lg font-bold" id="upgrade-cost">- Honor</span>
                        </div>
                    </div>

                    <button id="btn-upgrade" disabled class="self-center px-12 py-2 rounded-lg bg-[#847e31] hover:brightness-90 disabled:brightness-50 text-white font-bold text-lg shadow-lg transition-all active:scale-95">
                        Upgrade Weapon
                    </button>
                </div>
            </div>

            <!-- Upgrade Weapon -->
            <div class="shop-card rounded-2xl p-6 shadow-2xl flex flex-col justify-between hidden">
                <div>
                    <div class="flex justify-between items-center border-b-2 border-[#dba668] pb-4 mb-4">
                        <h2 class="text-3xl font-bold">Upgrade Senjata</h2>
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

                <button id="btn-upgrade" disabled class="bg-blue-600 hover:bg-blue-500 disabled:bg-gray-500 text-white w-full py-4 rounded-xl font-bold text-2xl shadow-lg transition-all active:scale-95">
                    UPGRADE SENJATA
                </button>
            </div>
        </div>

    </div>
@endsection

@section("script")
<script>
    // Custom SweetAlert Theme for Game Besar
    window.Swal = Swal.mixin({
        background: '#F0E9CF',
        color: '#733b22',
        confirmButtonColor: '#733b22',
        cancelButtonColor: '#a15b38',
        customClass: {
            popup: 'border-2 border-[#dba668] rounded-xl shadow-2xl font-sans',
            title: 'font-extrabold text-[#733b22]',
            confirmButton: 'font-bold rounded-lg px-6 py-2',
            cancelButton: 'font-bold rounded-lg px-6 py-2'
        }
    });

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
            $('#team-name-display').text($.trim(teamName));
        }
    });

    function openTab(route) {
        const teamId = selPlayer.val();
        let url = route;
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
            labelNextW.show().text("Sharpshooter");
            boxCostW.show();
            textCostW.text("600 Honor");
            btnUpgrade.prop('disabled', false).text("Upgrade Senjata");
        } else if (wLevel == 2) {
            $('#next-weapon-subtitle').show();
            labelNextW.show().text("Eagle Eye");
            boxCostW.show();
            textCostW.text("800 Honor");
            btnUpgrade.prop('disabled', false).text("Upgrade Senjata");
        } else {
            $('#next-weapon-subtitle').hide();
            labelNextW.show().text("MAX");
            boxCostW.hide();
            btnUpgrade.prop('disabled', true).text("Senjata Maksimal");
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
