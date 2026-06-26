@extends("si.layout.app")

@section("style")
    <style>
        :root{
            --c1: #733B22;
        }
        .resource-card {
            background: rgba(229, 209, 184, 0.9);
            border: 4px solid #ae8350;
        }
        .target-box {
            transition: all 0.2s ease-in-out;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.5);
            text-align: center;
        }
        .target-box:hover:not(.destroyed) {
            transform: scale(1.05) translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.6);
        }
        .target-box:active:not(.destroyed) {
            transform: scale(0.95);
        }

        /* Styles for different types */
        .target-small { width: 150px; height: 150px; background: #A66C3A; color: white; }
        .target-medium { width: 170px; height: 170px; background: #E5C18D; color: #593118; }
        .target-large { width: 200px; height: 200px; background: #FFF6CB; color: #411512; }

        .hp-bar-bg {
            width: 80%;
            height: 10px;
            background-color: rgba(0,0,0,0.5);
            border-radius: 5px;
            margin-top: 10px;
            overflow: hidden;
        }

        .hp-bar-fill-small{
            background: #D0D37C; /* merah */
        }

        .hp-bar-fill-medium{
            background: #9D933C; /* kuning */
        }

        .hp-bar-fill-large{
            background: #d1ce80; /* hijau */
        }
        .hp-bar-fill {
            height: 100%;
            transition: width 0.3s ease-in-out;
        }

        .target-box.selected-target {
            box-shadow: 0 0 0 6px #3b82f6, 0 0 20px rgba(59, 130, 246, 0.8) !important;
            border-color: #3b82f6 !important;
            transform: scale(1.05) translateY(-5px);
            z-index: 20;
        }

        .pyramid-row {
            display: flex;
            justify-content: center;
            align-items: flex-end;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }
        .container{
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            margin-bottom: 20px;
        }

        .navbar-nav{
            display: flex;
            gap: 30px;
            list-style: none;
            margin: 0;
            padding: 0;
        }
        .active-link,
        .active-link:hover {
            background-color: white;
            color: #8b181b !important;
            border-radius: 20px;
        }
        .image-container {
            position: relative;
            width: 300px;
            margin: 0 auto;
        }

        .image-container img {
            width: 100%;
            display: block;
        }
        .text-amunisi {
            position: absolute;
            top: 35%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            color: white;
        }
        .jumlah-amunisi {
            position: absolute;
            top: 60%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 30px;
            font-weight: 900;
            color: white;
        }

        #pID {
            width: 100%;
            padding-top: 10px;
            padding-bottom: 10px;
            padding-left: 20px;
            padding-right: 20px;
            border-radius: 1.5rem;
            border: none;
            outline: none;

            background-color: #8b181b;
            color: white;

            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;

            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='white' viewBox='0 0 24 24'%3E%3Cpath d='M7 10l5 5 5-5'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 18px center;
            background-size: 20px;

            padding-right: 50px;
        }
        .navbar-nav a {
            padding: 8px 25px;
            border-radius: 20px;
            display: inline-block;
        }
        .nav-link:hover:not(.active-link) {
            color: #FFD700;
            background: transparent;
        }

        /* Animations */
        @keyframes shake {
            0% { transform: translate(1px, 1px) rotate(0deg); }
            10% { transform: translate(-1px, -2px) rotate(-1deg); }
            20% { transform: translate(-3px, 0px) rotate(1deg); }
            30% { transform: translate(3px, 2px) rotate(0deg); }
            40% { transform: translate(1px, -1px) rotate(1deg); }
            50% { transform: translate(-1px, 2px) rotate(-1deg); }
            60% { transform: translate(-3px, 1px) rotate(0deg); }
            70% { transform: translate(3px, 1px) rotate(-1deg); }
            80% { transform: translate(-1px, -1px) rotate(1deg); }
            90% { transform: translate(1px, 2px) rotate(0deg); }
            100% { transform: translate(0px, 0px) rotate(0deg); }
        }
        .anim-shake {
            animation: shake 0.3s cubic-bezier(.36,.07,.19,.97) both;
        }

        .anim-damage {
            background-color: #ef4444 !important;
            transform: scale(0.9);
            transition: all 0.1s ease-in-out;
        }

        @keyframes burnStamp {
            0% { transform: scale(3); opacity: 0; }
            50% { transform: scale(0.8); opacity: 1; }
            100% { transform: scale(1); opacity: 1; }
        }
        .target-box.destroyed {
            background-color: #111827 !important;
            border: 2px solid #ef4444;
            color: #ef4444 !important;
            transition: all 0.5s ease-out;
            opacity: 0.8;
            box-shadow: inset 0 0 15px rgba(239, 68, 68, 0.4);
        }
        .target-box.destroyed .hp-text {
            animation: burnStamp 0.4s ease-out forwards;
            color: #ef4444 !important;
            font-size: 2.5rem !important;
            text-shadow: 0 0 10px rgba(239, 68, 68, 0.8);
            font-weight: bold;
        }
        .target-box.destroyed h3, .target-box.destroyed .hp-bar-bg {
            opacity: 0.3;
        }

        #arena-container{
            min-height: 600px;
        }
        #arena-container.active-arena {
            background-image: url("{{ asset('asset2026/Target Base/bg.png') }}");
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
        }

    </style>
@endsection

@section("content")
<div class="w-full max-w-[85vw] mx-auto min-h-[80vh] font-['Creato Display']">
     <!-- Header & Nav -->
    <div class="w-full flex flex-row justify-center items-stretch gap-4 mb-6">
        <div class="flex-1"></div>
        <div class="flex flex-row px-10 py-3 gap-2 rounded-full text-lg text-white font-bold bg-[#8b181b]">
            <button class="px-5 py-2 rounded-full {{ request()->routeIs('si.index') ? 'bg-white text-[#8b181b]' : 'text-white' }}">TARGET BASE</button>
            <button class="px-5 py-2 rounded-full {{ request()->routeIs('si.shop.index') ? 'bg-white text-[#8b181b]' : 'text-white' }}" onclick="openTab('{{ route('si.shop.index') }}')">SHOP</button>
        </div>
        <form method="POST" action="{{ route('logout') }}" class="flex flex-1 justify-end">
            @csrf
            <button type="submit" class="bg-white hover:bg-[#f3f3f3] text-[#8b181b] px-6 py-2 rounded-full text-lg font-bold shadow-md transition-colors">
                <i class="fa-solid fa-right-from-bracket mr-2"></i> LOGOUT
            </button>
        </form>
    </div>

    <div class="c-bg-white shadow-lg p-12 rounded-[36px] w-full max-w-[85vw] mx-auto flex flex-col relative min-h-screen">
        <!-- Player Selection -->
        <div class="rounded-2xl mb-6 flex flex-col md:flex-row items-center justify-between gap-4">
            <div id="team-name-display" class="flex items-center px-6 py-2 rounded-full uppercase text-lg text-white font-bold bg-[#8b181b]">
                TEAM NAME
            </div>

            <div class="w-full md:w-1/2 flex-grow">
                <select id="pID" class="text-lg font-bold">
                    <option selected disabled value="">-- PILIH TIM --</option>
                    @foreach ($players as $p)
                        <option value="{{ $p->id }}">
                            {{ $p->team_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="whitespace-nowrap min-w-[150px] text-center flex items-center justify-end gap-2">
                <span id="loading-indicator" class="text-white font-bold hidden bg-black/40 px-4 py-3 rounded-full text-lg"><i class="fa-solid fa-spinner fa-spin mr-2"></i> Memuat...</span>
                <button id="btn-reset" class="bg-red-600 hover:bg-red-700 text-white font-bold px-4 py-3 rounded-full text-lg hidden shadow-md transition-colors" title="Tutup Arena dan Sembunyikan Piramida">
                    <i class="fa-solid fa-xmark"></i> Tutup
                </button>
            </div>
        </div>

        <!-- Resource Stats -->
        <div class="grid grid-cols-2 gap-6 mb-6">
            <div class="image-container">
                <img src ="{{ asset('asset2026/Target Base/papan.png') }}" alt="Gambar">
                <div class="text-amunisi">AMUNISI PELURU</div>
                <span class="jumlah-amunisi" id="display-peluru">-</span>
            </div>
            <div class="image-container">
                <img src ="{{ asset('asset2026/Target Base/papan.png') }}" alt="Gambar">
                <div class="text-amunisi">NAMA SENJATA</div>
                <span class="jumlah-amunisi whitespace-nowrap" id="display-weapon">-</span>
            </div>
        </div>

        <!-- Attack Control Panel (Hidden initially) -->
        <div id="attack-controls" class="bg-[#847E30] p-4 rounded-xl mb-6 shadow-xl flex flex-col md:flex-row items-end justify-center gap-8 hidden">
            <div class="w-full md:w-auto flex flex-col">
                <label class="text-white font-bold mb-2 text-sm">Pilih Target:</label>
                <select id="target-select" class="w-full md:w-64 py-2 px-4 rounded-lg text-lg font-bold text-black bg-white focus:outline-none focus:ring-4 focus:ring-[#733b22] cursor-pointer">
                    <!-- Populated via JS -->
                </select>
            </div>
            <div class="w-full md:w-auto flex flex-col">
                <label class="text-white font-bold mb-2 text-sm">Jumlah Tembakan:</label>
                <input type="number" id="bullet-count" value="1" min="1" class="w-full md:w-32 py-2 px-4 rounded-lg text-lg font-bold text-black text-center bg-white focus:outline-none focus:ring-4 focus:ring-[#733b22]">
            </div>
            <button id="btn-fire" class="bg-[#8b181b] hover:bg-[#590212] text-white font-black px-8 py-2 rounded-lg text-xl shadow-lg transition-transform hover:scale-105 active:scale-95">
                <i class="fa-solid fa-crosshairs mr-2"></i> TEMBAK!
            </button>
        </div>

        <!-- Target Pyramid Area -->
        <div class="flex-grow bg-black/80 rounded-2xl bg-[#590212] p-6 shadow-2xl relative overflow-hidden" id="arena-container">
            <!-- Overlay Placeholder -->
            <div id="arena-overlay" class="absolute inset-0 z-10 bg-black/60 flex items-center justify-center backdrop-blur-sm">
                <h2 class="text-4xl font-bold text-white text-center font-['Lato'] drop-shadow-lg">SILAKAN PILIH TIM UNTUK MEMULAI PENYERANGAN</h2>
            </div>

            <div id="pyramid-wrapper" class="w-full h-full flex flex-col items-center justify-center opacity-0 transition-opacity duration-500">
                <!-- Pyramid will be rendered here by JS -->
            </div>
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
    const displayPeluru = $('#display-peluru');
    const displayWeapon = $('#display-weapon');
    const arenaOverlay = $('#arena-overlay');
    const pyramidWrapper = $('#pyramid-wrapper');

    let currentPeluru = 0;
    let weaponDamage = 0;
    let isAttacking = false;

    // Damage mapping matches controller
    const damageMap = {
        1: 5,
        2: 10,
        3: 15
    };

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

    selPlayer.on('change', function() {
        const playerId = $(this).val();
        if (!playerId) return;

        $('#loading-indicator').removeClass('hidden');
        $('#btn-shop').addClass('hidden');
        $('#btn-reset').addClass('hidden');
        $('#attack-controls').addClass('hidden');
        arenaOverlay.removeClass('hidden');
        pyramidWrapper.addClass('opacity-0');

        $.ajax({
            url: "{{ route('si.gameBesar.playerData') }}",
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                player_id: playerId
            },
            success: function(res) {
                $('#loading-indicator').addClass('hidden');

                currentPeluru = res.peluru;
                const wLevel = res.weapon_level;
                weaponDamage = damageMap[wLevel] || 5;

                displayPeluru.text(currentPeluru);
                displayWeapon.text(weaponNames[wLevel]);

                renderPyramid(res.bases);

                arenaOverlay.addClass('hidden');
                pyramidWrapper.removeClass('opacity-0');
                $('#btn-reset').removeClass('hidden');
                $('#btn-shop').removeClass('hidden');
                $('#attack-controls').removeClass('hidden');

                arenaOverlay.addClass('hidden');


                $('#arena-container').addClass('active-arena'); // tambahkan ini

                $('#btn-reset').removeClass('hidden');
            },
            error: function(err) {
                $('#loading-indicator').addClass('hidden');
                Swal.fire('Error', 'Gagal memuat data target base.', 'error');
            }
        });
    });

    function renderPyramid(bases) {
        pyramidWrapper.empty();
        $('#target-select').empty();

        // Categorize targets
        const smallBases = bases.filter(b => b.type === 'small');
        const mediumBases = bases.filter(b => b.type === 'medium');
        const largeBases = bases.filter(b => b.type === 'large');

        // Create rows (Inverted pyramid per user request: Top 4 Small, Mid 3 Medium, Bot 2 Large)
        const rows = [
            { id: 'row-small', bases: smallBases },
            { id: 'row-medium', bases: mediumBases },
            { id: 'row-large', bases: largeBases }
        ];

        let targetCounter = { 'small': 1, 'medium': 1, 'large': 1 };

        rows.forEach(row => {
            if (row.bases.length === 0) return;

            let rowHtml = `<div class="pyramid-row" id="${row.id}">`;

            row.bases.forEach(base => {
                const hpPercent = (base.current_hp / base.max_hp) * 100;
                const isDestroyed = (base.is_destroyed === true || base.is_destroyed == 1 || base.is_destroyed === 'true');
                const destroyedClass = isDestroyed ? 'destroyed' : '';
                const statusText = isDestroyed ? 'HANCUR' : 'HP: ' + base.current_hp + ' / ' + base.max_hp;

                const targetName = base.type.toUpperCase() + ' ' + targetCounter[base.type]++;

                // Add to dropdown if not destroyed
                if (!isDestroyed) {
                    $('#target-select').append(`<option value="${base.id}">${targetName} (${statusText})</option>`);
                }

                rowHtml += `
                    <div class="target-box target-${base.type} ${destroyedClass} rounded-2xl"
                         id="box-${base.id}"
                         data-id="${base.id}"
                         data-hp="${base.current_hp}"
                         data-maxhp="${base.max_hp}"
                         data-destroyed="${isDestroyed ? 1 : 0}"
                         data-name="${targetName}">
                        <h3 class=" text-6xl uppercase font-['Playbill']">${base.type}</h3>
                        <p class="font-bold text-sm mb-1">+${base.point_reward} pts</p>
                        <p class="hp-text font-['Playbill'] text-2xl">${statusText}</p>
                        <div class="hp-bar-bg hp-bar-bg-${base.type}">
                            <div class="hp-bar-fill hp-bar-fill-${base.type}" style="width: ${hpPercent}%"></div>
                        </div>
                    </div>
                `;
            });

            rowHtml += `</div>`;
            pyramidWrapper.append(rowHtml);
        });

        // Optional: click to select in dropdown
        $('.target-box').on('click', function() {
            const el = $(this);
            const targetId = el.data('id');
            const isDestroyed = el.data('destroyed') == 1;

            if (isDestroyed) {
                Swal.fire('Target Hancur', 'Target ini sudah hancur!', 'info');
                return;
            }

            $('#target-select').val(targetId);

            // Highlight selected
            $('.target-box').removeClass('selected-target');
            el.addClass('selected-target');

            // Reset bullet input to 1
            $('#bullet-count').val(1);
        });

        // Sync highlight when changing dropdown
        $('#target-select').on('change', function() {
            const targetId = $(this).val();
            $('.target-box').removeClass('selected-target');
            if (targetId) {
                $('#box-' + targetId).addClass('selected-target');
            }
        });

        // Highlight first option by default
        if ($('#target-select option').length > 0) {
            $('#target-select').trigger('change');
        }
    }

    $('#btn-fire').on('click', function() {
        const targetId = $('#target-select').val();
        const bulletCount = parseInt($('#bullet-count').val());

        if (!targetId) {
            Swal.fire('Perhatian', 'Tidak ada target yang dipilih atau semua target sudah hancur.', 'warning');
            return;
        }

        if (isNaN(bulletCount) || bulletCount < 1) {
            Swal.fire('Perhatian', 'Jumlah tembakan harus minimal 1.', 'warning');
            return;
        }

        if (currentPeluru < bulletCount) {
            Swal.fire('Peluru Habis!', `Tim ini hanya memiliki ${currentPeluru} peluru.`, 'warning');
            return;
        }

        if (isAttacking) return;

        const targetName = $('#box-' + targetId).data('name');
        const expectedDamage = bulletCount * weaponDamage;

        Swal.fire({
            title: 'Konfirmasi Tembakan',
            html: `Tembak <b>${targetName}</b> sebanyak <b>${bulletCount}x</b>?<br><br>Estimasi Damage: <b>${expectedDamage} HP</b>`,
            icon: 'crosshairs',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'TEMBAK!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                performAttack(targetId, bulletCount);
            }
        });
    });

    function performAttack(targetId, bulletCount) {
        isAttacking = true;
        const playerId = selPlayer.val();
        const el = $('#box-' + targetId);

        // Trigger animations
        const arena = $('#arena-container');
        arena.removeClass('anim-shake');
        void arena[0].offsetWidth; // trigger reflow
        arena.addClass('anim-shake');

        el.removeClass('anim-damage');
        void el[0].offsetWidth;
        el.addClass('anim-damage');

        $.ajax({
            url: "{{ route('si.gameBesar.attack') }}",
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                player_id: playerId,
                player_target_base_id: targetId,
                jumlah_tembakan: bulletCount
            },
            success: function(res) {
                isAttacking = false;
                setTimeout(() => el.removeClass('anim-damage'), 200);

                if (res.success) {
                    // Update visual state
                    currentPeluru = res.new_peluru;
                    displayPeluru.text(currentPeluru);

                    const newHp = res.current_hp;
                    const isDestroyed = res.is_destroyed;
                    const maxHp = parseInt(el.data('maxhp'));

                    el.data('hp', newHp);

                    if (isDestroyed) {
                        el.data('destroyed', 1);
                        el.addClass('destroyed');
                        el.removeClass('selected-target'); // Remove highlight if destroyed
                        el.find('.hp-text').text('HANCUR');
                        el.find('.hp-bar-fill').css('width', '0%');

                        // Remove from dropdown
                        $(`#target-select option[value="${targetId}"]`).remove();

                        // Trigger change to highlight the next available target
                        $('#target-select').trigger('change');

                        setTimeout(() => {
                            Swal.fire('Target hancur!', res.message, 'success');
                        }, 800);
                    } else {
                        const hpPercent = (newHp / maxHp) * 100;
                        el.find('.hp-text').text('HP: ' + newHp + ' / ' + maxHp);
                        el.find('.hp-bar-fill').css('width', hpPercent + '%');

                        // Update dropdown text
                        const targetName = el.data('name');
                        $(`#target-select option[value="${targetId}"]`).text(`${targetName} (HP: ${newHp} / ${maxHp})`);

                        // Re-trigger highlight in case they manually changed
                        $('#target-select').trigger('change');

                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true,
                        });
                        Toast.fire({
                            icon: 'success',
                            title: `Kena! (-${res.damage_dealt} HP)`
                        });
                    }
                } else {
                    Swal.fire('Gagal', res.message, 'error');
                }
            },
            error: function(err) {
                isAttacking = false;
                el.removeClass('scale-95 brightness-150');
                let msg = err.responseJSON ? err.responseJSON.message : 'Terjadi kesalahan sistem.';
                Swal.fire('Error', msg, 'error');
            }
        });
    }

    // Reset button to hide pyramid and maintain secrecy
    $('#btn-reset').on('click', function() {
        selPlayer.val(''); // Reset selection
        $('#btn-shop').addClass('hidden');
        $('#attack-controls').addClass('hidden');
        $(this).addClass('hidden');
        arenaOverlay.removeClass('hidden');
        pyramidWrapper.addClass('opacity-0');
        displayPeluru.text('-');
        displayWeapon.text('-');
        $('#arena-container').removeClass('active-arena');
    });
</script>
@endsection
