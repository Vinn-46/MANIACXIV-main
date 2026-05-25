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
                    placeholder="Scan QR Tim"
                />
            </label>
            <label class="form-control w-full rounded-lg">
                <div class="label">
                    <span class="label-text font-bold text-md">Pilih Score</span>
                </div>
                <select class="select select-bordered bg-[#F0E9CF] text-primary rounded-md font-medium" name="point_id" id="point_id" onchange="handlePointChange()">
                    <option disabled selected>--- Pilih Score ---</option>
                    @foreach($points as $point)
                        <option value="{{ $point->id }}" data-score="{{ $point->honor_reward }}" class="font-medium">{{ ucfirst($point->condition) }} ({{ $point->honor_reward }} Honor, {{ $point->peluru_reward }} Peluru)</option>
                    @endforeach
                </select>
            </label>
        </div>

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
                            <td width="20%" class="text-center">{{ ucfirst($score->point->condition) }}</td>

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
            <h3 class="text-lg font-bold text-white">Konfirmasi Input Score</h3>
            <p class="text-slate-50 mt-2">Apakah anda yakin ingin memasukkan data ini?</p>
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

        // console.log(`Code matched = ${decodedText}`, decodedResult);
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



        // Submit AJAX
        $.ajax({
            type: 'POST',
            url: '{{ route("penpos.store") }}',
            data: JSON.stringify({
                '_token': '{{ csrf_token() }}',
                'tim': $('#tim').val(),
                'point_id': $('#point_id').val()
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
            const pointValue = score?.point?.condition ?? '-';
            const scoreId = score?.id ?? '';

                <td width="30%" class="text-center">${teamName}</td>
                <td width="20%" class="text-center">${pointValue}</td>` +
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
        // Logika saat dropdown skor diubah jika dibutuhkan di masa depan.
    }

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


@endsection
