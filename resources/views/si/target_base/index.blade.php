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
        .target-box.destroyed {
            opacity: 0.5;
            cursor: not-allowed;
            filter: grayscale(100%);
        }
        
        /* Styles for different types */
        .target-small { width: 120px; height: 120px; background: linear-gradient(135deg, #ef4444, #991b1b); border: 4px solid #7f1d1d; color: white; }
        .target-medium { width: 150px; height: 150px; background: linear-gradient(135deg, #f59e0b, #b45309); border: 4px solid #78350f; color: white; }
        .target-large { width: 180px; height: 180px; background: linear-gradient(135deg, #10b981, #047857); border: 4px solid #064e3b; color: white; }

        .hp-bar-bg {
            width: 80%;
            height: 10px;
            background-color: rgba(0,0,0,0.5);
            border-radius: 5px;
            margin-top: 10px;
            overflow: hidden;
        }
        .hp-bar-fill {
            height: 100%;
            background-color: #4ade80;
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
    </style>
@endsection

@section("content")
    <div class="c-bg-white shadow-lg p-6 rounded-lg w-full max-w-[85vw] mx-auto flex flex-col relative">
        
        <!-- Header & Nav -->
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-5xl font-['dalek'] text-[#733b22]" style="text-shadow: -3px 2px 0px #be8f57">TARGET BASE</h1>
            <button id="btn-shop" onclick="openShop()" class="bg-[#dba668] hover:bg-[#be8f57] text-[#733b22] px-6 py-2 rounded-full font-['Lato'] font-bold text-lg shadow-md transition-colors border-2 border-[#733b22] hidden">
                <i class="fa-solid fa-store mr-2"></i> Shop
            </button>
        </div>

        <!-- Player Selection -->
        <div class="bg-gradient-to-r from-[#dba668] to-[#be8f57] p-4 rounded-2xl mb-6 flex flex-col md:flex-row items-center justify-between shadow-xl border-4 border-[#733b22] gap-4">
            <div class="flex items-center whitespace-nowrap">
                <span class="text-[#733b22] font-['Lato'] font-extrabold text-2xl uppercase tracking-wider">Pilih Tim :</span>
            </div>
            
            <div class="w-full md:w-1/2 flex-grow">
                <select id="pID" class="w-full py-3 px-6 rounded-xl text-xl font-['Lato'] font-bold shadow-inner text-[#733b22] border-4 border-[#733b22] bg-[#f0e9cf] focus:outline-none focus:ring-4 focus:ring-[#733b22] cursor-pointer appearance-none" name="state" style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23733B22%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 1rem top 50%; background-size: 1.5rem auto;">
                    <option selected disabled value="">-- Silakan Pilih Player --</option>
                    @foreach ($players as $p)
                        <option value="{{ $p->id }}">
                            {{ $p->team_name }}
                        </option>
                    @endforeach 
                </select>
            </div>

            <div class="whitespace-nowrap min-w-[150px] text-center flex items-center justify-end gap-2">
                <span id="loading-indicator" class="text-white font-bold hidden bg-black/40 px-4 py-3 rounded-lg text-lg"><i class="fa-solid fa-spinner fa-spin mr-2"></i> Memuat...</span>
                <button id="btn-reset" class="bg-red-600 hover:bg-red-700 text-white font-bold px-4 py-3 rounded-lg text-lg border-2 border-red-800 hidden shadow-md transition-colors" title="Tutup Arena dan Sembunyikan Piramida">
                    <i class="fa-solid fa-xmark"></i> Tutup
                </button>
            </div>
        </div>

        <!-- Resource Stats -->
        <div class="grid grid-cols-2 gap-6 mb-6">
            <div class="resource-card p-3 rounded-xl flex flex-col items-center justify-center text-[#733b22] shadow-lg">
                <span class="text-lg font-['Lato'] font-bold uppercase mb-1">Amunisi Peluru</span>
                <span class="text-3xl font-extrabold" id="display-peluru">-</span>
            </div>
            <div class="resource-card p-3 rounded-xl flex flex-col items-center justify-center text-[#733b22] shadow-lg">
                <span class="text-lg font-['Lato'] font-bold uppercase mb-1">Level Senjata</span>
                <span class="text-3xl font-extrabold" id="display-weapon">-</span>
            </div>
        </div>

        <!-- Attack Control Panel (Hidden initially) -->
        <div id="attack-controls" class="bg-gradient-to-r from-[#dba668] to-[#be8f57] p-4 rounded-xl mb-6 shadow-xl border-4 border-[#733b22] flex flex-col md:flex-row items-end justify-center gap-4 hidden">
            <div class="w-full md:w-auto flex flex-col">
                <label class="text-[#733b22] font-extrabold mb-2 uppercase text-sm tracking-widest">Pilih Target:</label>
                <select id="target-select" class="w-full md:w-64 py-2 px-4 rounded-lg text-lg font-bold text-[#733b22] border-2 border-[#733b22] bg-[#f0e9cf] focus:outline-none focus:ring-4 focus:ring-[#733b22] cursor-pointer">
                    <!-- Populated via JS -->
                </select>
            </div>
            <div class="w-full md:w-auto flex flex-col">
                <label class="text-[#733b22] font-extrabold mb-2 uppercase text-sm tracking-widest">Jumlah Tembakan:</label>
                <input type="number" id="bullet-count" value="1" min="1" class="w-full md:w-32 py-2 px-4 rounded-lg text-lg font-bold text-[#733b22] text-center border-2 border-[#733b22] bg-[#f0e9cf] focus:outline-none focus:ring-4 focus:ring-[#733b22]">
            </div>
            <button id="btn-fire" class="bg-red-600 hover:bg-red-700 text-white font-black px-8 py-2 rounded-lg text-xl shadow-lg transition-transform hover:scale-105 active:scale-95 border-b-4 border-red-800">
                <i class="fa-solid fa-crosshairs mr-2"></i> TEMBAK!
            </button>
        </div>

        <!-- Target Pyramid Area -->
        <div class="flex-grow bg-black/80 rounded-2xl border-4 border-[#ae8350] p-6 shadow-2xl relative overflow-hidden" id="arena-container">
            <!-- Overlay Placeholder -->
            <div id="arena-overlay" class="absolute inset-0 z-10 bg-black/60 flex items-center justify-center backdrop-blur-sm">
                <h2 class="text-4xl font-bold text-white text-center font-['Lato'] drop-shadow-lg">SILAKAN PILIH TIM UNTUK MEMULAI PENYERANGAN</h2>
            </div>
            
            <div id="pyramid-wrapper" class="w-full h-full flex flex-col items-center justify-center opacity-0 transition-opacity duration-500">
                <!-- Pyramid will be rendered here by JS -->
            </div>
        </div>

    </div>
@endsection

@section("script")
<script>
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

    $(document).ready(function() {
        const urlParams = new URLSearchParams(window.location.search);
        const teamId = urlParams.get('team_id');
        if (teamId) {
            selPlayer.val(teamId).trigger('change');
        }
    });

    function openShop() {
        const teamId = selPlayer.val();
        let url = "{{ route('si.shop.index') }}";
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
                displayWeapon.text("LV. " + wLevel + " (DMG: " + weaponDamage + ")");

                renderPyramid(res.bases);
                
                arenaOverlay.addClass('hidden');
                pyramidWrapper.removeClass('opacity-0');
                $('#btn-reset').removeClass('hidden');
                $('#btn-shop').removeClass('hidden');
                $('#attack-controls').removeClass('hidden');
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
                const destroyedClass = base.is_destroyed ? 'destroyed' : '';
                const statusText = base.is_destroyed ? 'HANCUR' : 'HP: ' + base.current_hp + ' / ' + base.max_hp;
                
                const targetName = base.type.toUpperCase() + ' ' + targetCounter[base.type]++;
                
                // Add to dropdown if not destroyed
                if (!base.is_destroyed) {
                    $('#target-select').append(`<option value="${base.id}">${targetName} (${statusText})</option>`);
                }

                rowHtml += `
                    <div class="target-box target-${base.type} ${destroyedClass} rounded-2xl" 
                         id="box-${base.id}"
                         data-id="${base.id}" 
                         data-hp="${base.current_hp}" 
                         data-maxhp="${base.max_hp}"
                         data-destroyed="${base.is_destroyed ? 1 : 0}"
                         data-name="${targetName}">
                        <h3 class="font-extrabold text-2xl uppercase font-['dalek'] tracking-widest">${base.type}</h3>
                        <p class="font-bold text-sm mb-1">+${base.point_reward} Pts</p>
                        <p class="hp-text font-bold text-lg mb-1">${statusText}</p>
                        <div class="hp-bar-bg">
                            <div class="hp-bar-fill" style="width: ${hpPercent}%"></div>
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
        
        el.addClass('scale-95 brightness-150');

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
                el.removeClass('scale-95 brightness-150');

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

                        Swal.fire('💥 TARGET HANCUR!', res.message, 'success');
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
    });
</script>
@endsection
