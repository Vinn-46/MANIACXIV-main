@extends('penpos.layout.index')
@php($user = auth()->user())
@section('styles')
<style>
    .input-danger {
        border: 2px solid #dc2626 !important; /* Tailwind red-600 */
        background-color: #fee2e2; /* Tailwind red-100 */
    }

    .danger-icon {
        color: #dc2626;
        margin-left: 5px;
    }
</style>
@endsection

@section('content')
    <div role="alert" class="alert alert-info flex flex-wrap items-center justify-between rounded-lg p-4">
        <span class="flex-grow text-start break-words">
            Hi, <strong>{{ ucfirst($user->username) }}</strong>! Have a nice day :)
        </span>
        <button class="bg-yellow-400 text-black px-4 py-1 rounded hover:bg-yellow-500 transition-all font-semibold flex-shrink-0" onclick="openConfirmInformSIModal({{ $user->rallyGame->id }})">
            Panggil SI
        </button>
    </div>
    <div role="alert" class="alert rounded-lg mt-4 text-start bg-[#F0E9CF]">
        <div>
            <ul class="list-disc list-inside">
                <li>Selamat Datang di Pos <strong>{{ $user->rallyGame->name }}</strong></li>
                <li>Di sini, anda dapat melakukan penilaian Rally Games</li>
                <li><strong>Scan QR</strong> Tim yang ingin diberi score</li>
                <li>Kemudian, pilih <strong>jumlah score</strong> dan klik button <strong>Submit</strong></li>
            </ul>
        </div>
    </div>
    <div class="grid grid-cols-1 mt-4 bg-[#BE8F57] rounded p-4">
        <div id="reader" width="600px" style="" class="mb-2"></div>
        <div class="rounded p-4 pt-0 border-[2px] border-[#e5d1b8]">
            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text font-bold text-md">Tim</span>
                </div>
                <input type="text"
                    class="input w-full bg-[#F0E9CF] text-primary rounded-md font-medium"
                    id="tim"
                    name="tim"
                    readonly
                />
            </label>
            <label class="form-control w-full rounded-lg">
                <div class="label">
                    <span class="label-text font-bold text-md">Pilih Score</span>
                </div>
                <select class="select select-bordered bg-[#F0E9CF] text-primary rounded-md font-medium" name="point_id" id="point_id" onchange="handlePointChange()">
                    <option disabled selected>--- Pilih Score ---</option>
                    @foreach($points as $point)
                        <option value="{{ $point->id }}" data-score="{{ $point->value }}" class="font-medium">{{ $point->value }}</option>
                    @endforeach
                </select>
            </label>
        </div>
        @if(false)
            {{-- ADD RELIC --}}
            <div id="addRelicSection" class="grid grid-cols-1 mt-4 bg-[#BE8F57] rounded p-4 border-[2px] border-[#e5d1b8] hidden">
                <div class="label-text font-bold text-lg p-1 my-2 text-center">
                    Jatah Relic Terpakai: <span id="jatahUsed">-</span> dari <span id="jatahMax">-</span>
                </div>
                @foreach($relics as $relic)
                    <div class="bg-[#e5d1b8] rounded-lg p-3 shadow flex flex-col sm:flex-row sm:items-center sm:justify-between mb-2">
                        <div class="flex items-center gap-4">
                            <div>
                                <p class="text-lg font-bold text-[#6e481a] title">{{ $relic->nama }} ({{ $relic->color }})</p>
                                <p class="text-sm text-gray-700">Stock Tersisa: <span class="font-semibold" id="stock-{{ $relic->color }}">-</span></p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <button type="button" class="px-3 py-1 bg-red-500 text-white rounded" onclick="adjustRelic('{{ $relic->color }}', -1)">-</button>
                            <div class="relative flex items-center">
                                <input type="number" id="input-{{ $relic->color }}" value="0" min="0" class="w-16 text-center rounded border border-gray-400" onchange="updateJatahUsed()">
                                <span id="icon-{{ $relic->color }}" class="danger-icon hidden">⚠️</span>
                            </div>
                            <button type="button" class="px-3 py-1 bg-green-600 text-white rounded" onclick="adjustRelic('{{  $relic->color }}', 1)">+</button>
                        </div>

                    </div>
                @endforeach
            </div>
            {{-- Relic Mission Display --}}
            <div class="grid grid-cols-1 mt-6 bg-[#BE8F57] rounded p-4 border-[2px] border-[#e5d1b8]">
                <div class="text-lg font-bold text-center label-text mb-4">Relic Misi Aktif</div>
                @if($relicsInMission === null || $relicsInMission->count() === 0)
                    <div class="text-center text-white font-semibold">Tidak ada sesi aktif saat ini.</div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        <?php $relic_images = ['asset2025/gameBesar/relic-red.png', 'asset2025/gameBesar/relic-purple.png', 'asset2025/gameBesar/relic-blue.png']; ?>
                        @foreach($relicsInMission as $idx => $relics)
                            <div class="relative bg-[#e5d1b8] rounded-lg p-3 flex flex-col items-center shadow">
                                <img src="{{ asset($relic_images[$idx]) }}" class="h-24">
                                <p class="text-md font-bold text-center text-[#6e481a] mt-2">{{ $relics->relic->nama }}<br>({{ $relics->relic->color }})</p>
                                <div class="absolute bottom-2 right-2 bg-[#6e481a] text-white text-xs font-bold px-2 py-1 rounded-full">
                                    x{{ $relics->qty }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            {{-- Player Inventory Display --}}
            <div id="playerInventoryBox" class="grid grid-cols-1 mt-6 bg-[#BE8F57] rounded p-4 border-[2px] border-[#e5d1b8] hidden">
                <div class="text-lg font-bold text-center label-text mb-4">Relic Inventory Pemain</div>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4" id="inventoryItems">
                    {{-- Inventory items will be injected here --}}
                </div>
            </div>
        @endif
        <div class="modal-action">
            <button class="btn btn-primary" id="btnSubmit" type="button">Submit Score</button>
        </div>
    </div>

    <div class="grid grid-cols-1 mt-4">
        <div class="overflow-x-auto">
            <table class="table table-zebra">
                <!-- head -->
                <thead>
                    <tr>
                        <th width="25%" class="text-center">Tim</th>
                        <th width="20%" class="text-center">Point</th>
                        <th width="20%" class="text-center">Hapus</th>
                    </tr>
                </thead>
                <tbody id="scoresBody">
                    @foreach($scores as $score)
                        <tr>
                            <td width="25%" class="text-center">{{ $score->player->team->name }}</td>
                            <td width="20%" class="text-center">{{ $score->point->value }}</td>
                            @if(false)
                                <td width="35%" class="text-center">
                                    <?php $relics = $score->relicChosen; ?>
                                    @if($relics)
                                        <span class="text-red-500 font-bold">{{ $relics->red_relic_qty }} 🔴</span><br>
                                        <span class="text-purple-500 font-bold">{{ $relics->purple_relic_qty }} 🟣</span><br>
                                        <span class="text-blue-500 font-bold">{{ $relics->blue_relic_qty }} 🔵</span><br>
                                    @else
                                        <span class="text-gray-400 italic">-</span>
                                    @endif
                                </td>
                            @endif
                            <td width="20%" class="text-center">
                                <button class="btn btn-error btn-md rounded" onclick="openModalHapus('{{ $score->id }}', '{{ $score->player->team->name }}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{--  Modal Hapus  --}}
    <dialog id="modalHapus" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <h3 class="font-bold text-2xl">Konfirmasi Delete Score</h3>
            <p class="pt-4">Apakah anda yakin untuk menghapus Score untuk tim <strong><span id="teamHapus"></span></strong></p>
            <div class="modal-action">
                <button class="btn btn-error" id="btnHapus">Hapus</button>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>

    {{--  Modal Informasi  --}}
    <dialog id="confirmInformSIModal" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box bg-[#733B22]">
            <h3 class="text-lg font-bold text-white">Konfirmasi Panggil SI</h3>
            <p class="text-slate-50 mt-2">Apakah anda yakin ingin memanggil SI?</p>
            <div class="modal-action">
            <button id="confirmInformSIYes" class="bg-green-600 text-white font-semibold py-2.5 px-4 rounded-lg hover:bg-green-700 active:scale-95 transition-all">
                Yes
            </button>
            <button id="confirmInformSICancel" class="bg-red-600 text-slate-50 font-semibold py-2.5 px-4 rounded-lg hover:bg-red-700 active:scale-95 transition-all">
                Cancel
            </button>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop"><button>close</button></form>
    </dialog>

    <dialog id="confirmSubmitModal" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box bg-[#733B22]">
            <h3 class="text-lg font-bold text-white">Konfirmasi Input Relic</h3>
            <p class="text-slate-50 mt-2">Apakah sudah input relic (jika stok memungkinkan)?</p>
            <div class="modal-action">
                <button id="confirmSubmitYes" class="bg-green-600 text-white font-semibold py-2.5 px-4 rounded-lg hover:bg-green-700 active:scale-95 transition-all">
                    Yes
                </button>
                <button id="confirmSubmitCancel" class="bg-red-600 text-slate-50 font-semibold py-2.5 px-4 rounded-lg hover:bg-red-700 active:scale-95 transition-all">
                    Cancel
                </button>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop"><button>close</button></form>
    </dialog>
@endsection

@section('scripts')
<script>
    var notyf = new Notyf({
        position: {
            x: 'center',
            y: 'top'
        }
    });

    var showNotifError = (msg, isError = false) => {
        if (isError) {
            notyf.error({
                message: msg,
                duration: 3500,
                dismissible: true
            });
        } else {
            notyf.success({
                message: msg,
                duration: 3500,
                dismissible: true
            });
        }
    }

    function onScanSuccess(decodedText, decodedResult) {
        if ($("#tim").attr("value") != decodedText) {
            notyf.success({
                message: `Sukses Scanning ${decodedText}`,
                duration: 1750,
                dismissible: true
            });
        }

        $("#tim").attr("value", decodedText);

        // For interface of player inventory
        //fetchPlayerInventory(decodedText);

        console.log(`Code matched = ${decodedText}`, decodedResult);
    }

    function onScanFailure(error) {
        // handle scan failure, usually better to ignore and keep scanning.
        // for example:
        // console.warn(`Code scan error = ${error}`);
    }

    let html5QrcodeScanner = new Html5QrcodeScanner(
        "reader", {
            fps: 10,
            qrbox: {
                width: 250,
                height: 250
            }
        },
        /* verbose= */
        false);
    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
</script>
<script>
    const btnSubmit = document.getElementById('btnSubmit');
    const modalHapus = document.getElementById('modalHapus');
    const teamHapus = document.getElementById('teamHapus');
    const btnHapus = document.getElementById('btnHapus');

    const confirmModal = document.getElementById('confirmSubmitModal');
    const confirmYesBtn = document.getElementById('confirmSubmitYes');
    const confirmCancelBtn = document.getElementById('confirmSubmitCancel');

    btnSubmit.addEventListener('click', () => {
        confirmModal.showModal();
    });

    confirmYesBtn.addEventListener('click', () => {
        confirmModal.close();
        submitScore();
    });

    confirmCancelBtn.addEventListener('click', () => {
        confirmModal.close();
    });

    const submitScore = () => {
        if ($("#tim").val() == "" || $("#point_id").val() == null) {
            return showNotifError("Silahkan scan QR atau Pilih score yang ingin diinput!", true);
        }

        console.log($('#tim').val());
        console.log($('#point_id').val());

        btnSubmit.disabled = true;

        // // Gather relics and their quantities
        // let relics = {};
        // document.querySelectorAll('[id^="input-"]').forEach(input => {
        //     const color = input.id.replace('input-', '');
        //     const quantity = parseInt(input.value || 0);
        //     relics[color] = quantity;
        // });
        // console.log("CHOSEN RELICS: " + relics);

        // Submit AJAX
        $.ajax({
            type: 'POST',
            url: '{{ route("penpos.store") }}',
            data: JSON.stringify({
                '_token': '{{ csrf_token() }}',
                'tim': $('#tim').val(),
                'point_id': $('#point_id').val(),
                //'relics': relics
            }),
            contentType: 'application/json',
            processData: false,
            dataType: 'json',
            success: function(data) {
                if (data.msg == "YES") {
                    return showNotifError("Gagal Submit! Team sudah pernah main di pos ini.", true);
                }

                console.log(data);
                showNotifError(data.desc);
                updateTableScore(data.scores);

                if (data.redirect) {
                    sessionStorage.setItem("addPointData", JSON.stringify(data));
                    window.location.href = data.route;
                }
            },
            error: function(xhr) {
                const res = xhr.responseJSON;
                if (res && res.error_code) {
                    showNotifError(res.error_message, true);
                } else {
                    showNotifError("Terjadi kesalahan saat submit.", true);
                }
            },
            complete: function() {
                btnSubmit.disabled = false;
            }
        });
    }

    const openModalHapus = (scoreId, team) => {
        teamHapus.innerHTML = team;
        btnHapus.onclick = function () {
            hapusScore(scoreId);
        }

        // Buka Modal
        modalHapus.showModal();
    }

    console.log();

    const hapusScore = (scoreId) => {
        let url = `{{ route('penpos.index') }}/${scoreId}/destroy`;
        $.ajax({
            type: 'post',
            url: url,
            data: {
                '_token': '{{ csrf_token() }}',
                '_method': 'delete',
                "user_id": {{ Auth::User()->id }},
                "scoreId": scoreId
            },
            success: function (data) {
                showNotifError(data.msg);

                console.log(data);
                updateTableScore(data.scores);
            },
            error: function (xhr) {
                showNotifError(
                    "Error AJAX! Beberapa kesalahan seperti tim blm pernah diinputkan. Segera Hubungi SI!!!",
                    isError=true
                );
                console.log(xhr);
            },
            complete: function (data) {
                modalHapus.close();
            }
        });
    }

    const updateTableScore = (scoresData) => {
        const tbody = document.getElementById("scoresBody");
        tbody.innerHTML = '';

        for (const score of Object.values(scoresData)) {
            const teamName = score?.player?.team?.name ?? 'N/A';
            const pointValue = score?.point?.value ?? 0;
            const scoreId = score?.id ?? '';

            //const red = score?.relic_chosen?.red_relic_qty ?? 0;
            //const blue = score?.relic_chosen?.blue_relic_qty ?? 0;
            //const purple = score?.relic_chosen?.purple_relic_qty ?? 0;

            //const relicDisplay = `
            //    <span class="text-red-600 font-semibold">${red} 🔴</span><br>
            //    <span class="text-purple-600 font-semibold">${purple} 🟣</span><br>
            //    <span class="text-blue-600 font-semibold">${blue} 🔵</span><br>
            //`;

            const row = document.createElement('tr');
            row.innerHTML = `
                <td width="30%" class="text-center">${teamName}</td>
                <td width="20%" class="text-center">${pointValue}</td>` +
                // <td width="30%" class="text-center">${relicDisplay}</td>
                `<td width="20%" class="text-center">
                    <button class="btn btn-error btn-md rounded" onclick="openModalHapus('${scoreId}', '${teamName}')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-trash-fill" viewBox="0 0 16 16">
                            <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                        </svg>
                    </button>
                </td>
            `;
            tbody.appendChild(row);
        }
    };

    function handlePointChange() {
        const select = document.getElementById('point_id');
        const selectedOption = select.options[select.selectedIndex];

        const score = parseInt(selectedOption.dataset.score || 0);
        //const relicQty = parseInt(selectedOption.dataset.relic_qty || 0);

        //const addRelicSection = document.getElementById('addRelicSection');

        if (score > 0) {
        //    addRelicSection.classList.remove('hidden');
        //    addRelicSection.classList.add('grid');

        //    document.getElementById('jatahMax').innerText = relicQty;
        //    updateJatahUsed();
        //} else {
        //    addRelicSection.classList.remove('grid');
        //    addRelicSection.classList.add('hidden');

            // Update input values
            const inputs = document.querySelectorAll('[id^="input-"]'); // Starts with 'input-'
            inputs.forEach(input => {
                input.value = 0;
            });
            //document.getElementById('jatahUsed').innerText = 0;
        }
    }

    /*
    function updateJatahUsed() {
        let totalUsed = 0;
        const inputs = document.querySelectorAll('[id^="input-"]'); // Starts with 'input-'

        inputs.forEach(input => {
            const color = input.id.replace("input-", "");
            const stock = parseInt(document.getElementById(`stock-${color}`).innerText || 0);
            const value = parseInt(input.value) || 0;
            totalUsed += value;

            // Warning symbol if amount exceeds the stock available
            const icon = document.getElementById(`icon-${color}`);

            if (value > stock) {
                input.classList.add('input-danger');
                icon.classList.remove('hidden');
                input.title = `Jumlah yang dimasukkan melebihi stok (${stock})`;
            } else {
                input.classList.remove('input-danger');
                icon.classList.add('hidden');
                input.title = '';
            }
        });

        document.getElementById('jatahUsed').innerText = totalUsed;
    }

    function adjustRelic(color, delta) {
        const input = document.getElementById(`input-${color}`);

        let value = parseInt(input.value || 0);
        const max = parseInt(input.max || 0);
        const min = parseInt(input.min || 0);

        const jatahMax = parseInt(document.getElementById('jatahMax').innerText || 0);
        const totalUsed = calculateTotalUsed();

        if (delta > 0) {
            if (totalUsed >= jatahMax) {
                showNotifError(
                    "Jumlah jatah relic sudah terpakai. Tidak bisa menambahkan lagi.",
                    true
                );
                return;
            }
        }

        value += delta;

        if (value > max) value = max;
        if (value < min) value = min;

        input.value = value;

        updateJatahUsed();
    }

    function calculateTotalUsed() {
        let total = 0;
        document.querySelectorAll('[id^="input-"]').forEach(input => {
            total += parseInt(input.value || 0);
        });
        return total;
    }

    function fetchPlayerInventory(teamName) {
        $.ajax({
            url: '{{ route("penpos.getPlayerInventory") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                team_name: teamName
            },
            success: function (res) {
                const itemsContainer = $("#inventoryItems");
                itemsContainer.empty(); // clear old entries

                // To fix mismatch relic images
                const relicImageMap = {
                    1: 'relic-red.png',
                    2: 'relic-purple.png',
                    3: 'relic-blue.png',
                };

                res.inventory.forEach(item => {
                    const imagePath = `{{ asset('asset2025/gameBesar') }}/${relicImageMap[item.relic_id]}`;
                    const html = `
                        <div class="relative bg-[#e5d1b8] rounded-lg p-3 flex flex-col items-center shadow">
                            <img src="${imagePath}" class="h-24">
                            <p class="text-md font-bold text-center text-[#6e481a] mt-2">${ item.nama }</br>(${ item.color })</p>
                            <div class="absolute bottom-2 right-2 bg-[#6e481a] text-white text-xs font-bold px-2 py-1 rounded-full">
                                x${item.qty}
                            </div>
                        </div>
                    `;
                    itemsContainer.append(html);
                });

                $("#playerInventoryBox").removeClass("hidden");
            },
            error: function (err) {
                console.error(err);
                Swal.fire({
                    title: 'Gagal',
                    text: 'Gagal memuat data inventori pemain.',
                    icon: 'error'
                });
            }
        });
    }
    */

    let pendingRallyGameId = null; // For modal panggil SI

    function openConfirmInformSIModal(rallyGameId) {
        pendingRallyGameId = rallyGameId;
        const modal = document.getElementById('confirmInformSIModal');
        modal.showModal();
    }

    document.getElementById('confirmInformSIYes').addEventListener('click', () => {
        const modal = document.getElementById('confirmInformSIModal');
        modal.close();
        if (pendingRallyGameId !== null) {
            informSI(pendingRallyGameId);
            pendingRallyGameId = null;
        }
    });

    document.getElementById('confirmInformSICancel').addEventListener('click', () => {
        const modal = document.getElementById('confirmInformSIModal');
        modal.close();
        pendingRallyGameId = null;
    });

    function informSI(rallyGameId) {
        fetch("{{ route('penpos.informSI') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                rallyGame_id: rallyGameId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotifError('SI has been notified.', false);
            } else {
                showNotifError('Failed to notify SI.', true);
            }
        })
        .catch(() => {
            showNotifError('Error connecting to server.', true);
        });
    }

    function showInformSIModal(message) {
        const modal = document.getElementById('informSIModal');
        const messageEl = document.getElementById('informSIModalMessage');
        messageEl.textContent = message;
        modal.showModal();

        const closeBtn = document.getElementById('informSIModalCloseBtn');
        closeBtn.onclick = () => modal.close();
    }

    @if(false)
        window.addEventListener('DOMContentLoaded', function () {
            setTimeout(() => {
                $.ajax({
                    url: '{{ route("penpos.updateStock") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (res) {
                        console.log("Stock updated via event.");
                    },
                    error: function (err) {
                        console.error("Failed to update stock:", err);
                    }
                });
            }, 500); // delay of loading stock, first time (milliseconds)
        });
    @endif
</script>
@if(false)
    @vite('resources/js/app.js')
    <script type="module">
        window.Echo.channel('update-available-stock').listen('UpdateAvailableStock', event => {
            console.log("[UpdateAvailableStock] Event:", event);

            // Display
            $('#stock-red').text(event.availableStock.red_relic_stock);
            $('#stock-blue').text(event.availableStock.blue_relic_stock);
            $('#stock-purple').text(event.availableStock.purple_relic_stock);

            // Max
            $('#input-red').attr('max', event.availableStock.red_relic_stock);
            $('#input-blue').attr('max', event.availableStock.blue_relic_stock);
            $('#input-purple').attr('max', event.availableStock.purple_relic_stock);

            updateJatahUsed();
        });
    </script>
@endif
@endsection
