@extends('supersi.layout.index', ['pageActive' => 'super-si.gamebesar', 'pageTitle' => 'Game Besar'])

@php
    if (!session()->has('tab')) {
        $currTab = 'session';
    } else {
        $currTab = session()->get('tab');
    }
@endphp

@section('styles')
    <style>
        [type='radio'],
        [type='radio']:checked {
            background: none;
            /*border: none;*/
            --tw-ring-offset-color: none;
            --tw-ring-color: none;
            --tw-ring-offset-shadow: none;
            --tw-ring-shadow: none;
            --tw-shadow: none;
            --tw-shadow-colored: none;
        }

        .tabs-lifted>.tab.tab-active:not(.tab-disabled):not([disabled]),
        .tabs-lifted>.tab:is(input:checked) {
            background-color: #475569;
        }

        .tab {
            --tab-border-color: transparent;
            --tab-bg: #475569;
        }
    </style>
@endsection

@section('content')
    {{--  Breadcrumbs  --}}
    <div class="breadcrumbs text-sm">
        <ul>
            <li>
                <a href="{{ route('super-si.gamebesar.index') }}" class="font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        class="h-4 w-4 stroke-current mr-1">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z">
                        </path>
                    </svg>
                    Game Besar
                </a>
            </li>
        </ul>
    </div>

    {{--  Alert  --}}
    <div>
        @if (session()->has('addSuccess'))
            <div role="alert" class="alert rounded-md bg-green-300 border-none mt-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session()->get('addSuccess') }}</span>
            </div>
        @elseif(session()->has('updateSuccess'))
            <div role="alert" class="alert rounded-md bg-green-300 border-none mt-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session()->get('updateSuccess') }}</span>
            </div>
        @elseif(session()->has('error'))
            <div role="alert" class="alert rounded-md bg-red-300 border-none mt-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session()->get('error') }}</span>
            </div>
        @endif
        @error('mission')
            <div role="alert" class="alert rounded-md bg-red-300 border-none mt-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span><strong>{{ $message }}</strong></span>
            </div>
        @enderror
        @error('open')
            <div role="alert" class="alert rounded-md bg-red-300 border-none mt-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span><strong>{{ $message }}</strong></span>
            </div>
        @enderror
        @error('close')
            <div role="alert" class="alert rounded-md bg-red-300 border-none mt-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span><strong>{{ $message }}</strong></span>
            </div>
        @enderror
    </div>

    {{--  Content  --}}
    <div class="flex flex-col justify-center content-center w-full bg-slate-400 p-3 rounded-md mt-4">
        <div class="w-full my-6">
            <!-- Button to open modal -->
            <button
                id="openResetModalBtn"
                class="w-full bg-red-600 text-white font-semibold py-3 px-4 rounded hover:bg-red-700 active:scale-95 transition-all"
            >
                Reset All Player Inventories
            </button>

            <!-- Hidden form to submit -->
            <form id="resetInventoryForm" action="{{ route('super-si.gamebesar.resetInventory') }}" method="POST" style="display:none;">
                @csrf
                @method('PATCH')
            </form>

            <!-- Backup Database Link -->
            <a href="{{ route('super-si.backup.db') }}"
                class="w-full inline-block text-center bg-blue-600 text-white font-semibold py-3 px-4 rounded hover:bg-blue-700 active:scale-95 transition-all">
                Backup Database
            </a>
        </div>
        <dialog id="resetModal" class="modal modal-bottom sm:modal-middle">
            <div class="modal-box bg-slate-800">
                <h3 class="text-lg font-bold text-slate-50">Confirm Reset</h3>
                <p class="py-4 text-slate-300">
                    Are you sure you want to reset all player inventories? This action cannot be undone.
                </p>

                <div class="modal-action">
                    <button id="cancelResetBtn" type="button"
                        class="bg-slate-600 text-slate-50 font-semibold py-2.5 px-4 rounded-lg hover:bg-slate-500 active:scale-95 transition-all">
                        Cancel
                    </button>

                    <button id="confirmResetBtn" type="button"
                        class="bg-red-600 text-white font-semibold py-2.5 px-4 rounded-lg hover:bg-red-700 active:scale-95 transition-all">
                        Confirm Reset
                    </button>
                </div>
            </div>

            <form method="dialog" class="modal-backdrop">
                <button>close</button>
            </form>
        </dialog>
        <div role="tablist" class="tabs tabs-lifted">
            {{--  Session  --}}
            <input type="radio" name="my_tabs_2" role="tab" class="tab bg-slate-500 font-medium text-slate-50"
                aria-label="Session" {{ $currTab == 'session' ? 'checked' : '' }} />
            <div role="tabpanel" class="tab-content bg-slate-500 rounded p-6 overflow-auto">
                {{--  Table  --}}
                <div class="overflow-auto rounded" style="max-height: 600px">
                    <table class="table table-xs table-pin-cols table-pin-rows">
                        <thead class="">
                            <tr class="text-slate-900 font-medium" style="font-size: 1.1rem;">
                                <th width="5%" class="text-center py-3">Sesi</th>
                                <th width="20%" class="text-center py-3">Open</th>
                                <th width="20%" class="text-center py-3">Close</th>
                                <th width="25%" class="text-center py-3">Mission</th>
                                <th width="10%" class="text-center py-3">Stock</th>
                                <th width="10%" class="text-center py-3">Status</th>
                                <th width="10%" class="text-center py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody id="tBody">
                            @foreach ($sessions as $idx => $session)
                                <tr class="text-slate-900 font-medium" style="font-size: 0.9rem;">
                                    <td width="5%" class="text-center py-5 text-white">{{ $idx + 1 }}</td>
                                    <td width="20%" class="text-center py-5 text-white">{{ $session->open }}</td>
                                    <td width="20%" class="text-center py-5 text-white">{{ $session->close }}</td>
                                    <td width="25%" class="text-center py-5 text-white">{{ $session->mission->name }}</td>
                                    <td width="10%" class="text-center py-5 text-white">
                                        <div class="flex flex-col gap-1 items-center">
                                            <span class="text-red-400" id="stock-red-{{ $session->id }}">🔴 {{ $session->red_relic_stock }}</span>
                                            <span class="text-blue-400" id="stock-blue-{{ $session->id }}">🔵 {{ $session->blue_relic_stock }}</span>
                                            <span class="text-purple-400" id="stock-purple-{{ $session->id }}">🟣 {{ $session->purple_relic_stock }}</span>
                                        </div>
                                    </td>
                                    <td width="10%" class="text-center py-5 text-white">
                                        @php
                                            $status = 'inactive';
                                            $badge = 'bg-slate-600';

                                            if (
                                                $session->open <= \Illuminate\Support\Carbon::now() &&
                                                $session->close >= \Illuminate\Support\Carbon::now()
                                            ) {
                                                $status = 'active';
                                                $badge = 'bg-green-900';
                                            }
                                        @endphp
                                        <div class="badge border-none text-slate-50 font-medium {{ $badge }}">
                                            {{ $status }}
                                        </div>
                                    </td>
                                    <td width="10%" class="text-center">
                                        <button
                                            class="bg-slate-900 text-slate-50 font-semibold py-2 px-5 rounded hover:bg-slate-700 active:scale-95 transition-all"
                                            onclick="window.location = '{{ route('super-si.gamebesar.index') }}/session/{{ $session->id }}'">
                                            Edit
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{--  Add Session  --}}
                <button
                    class="w-full bg-sky-700 text-slate-50 font-semibold py-2 px-3 rounded hover:bg-sky-600 active:scale-95 transition-all"
                    onclick="openAddModal()">
                    Add
                </button>
            </div>
        </div>
    </div>

    {{--  Add Modal --}}
    <dialog id="addModal" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box bg-slate-800">
            <h3 class="text-lg font-bold">Add Session</h3>
            <form action="{{ route('super-si.gamebesar.session.add') }}" method="POST" id="formAdd">
                @csrf
                <div class="grid grid-cols-1 gap-x-10 mb-4">
                    <div class="grid grid-cols-1">
                        <label class="form-control w-full">
                            <div class="label">
                                <span class="label-text text-slate-50">Misi</span>
                            </div>
                            <select name="mission_id" id="select" class="select-bordered rounded bg-slate-300 text-slate-800 font-medium" required>
                                <option value="" disabled selected>-- Pilih Misi --</option>
                                @foreach ($missions as $mission)
                                    <option value="{{ $mission->id }}" class="text-slate-800" >{{ $mission->name }}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>
                    <div>
                        <label for="" class="form-control w-full">
                            <div class="label">
                                <span class="label-text text-slate-50">Tanggal Buka</span>
                            </div>
                            <div class="flex flex-col justify-center items-center gap-y-5">
                                <input type="text" id="addOpenDate" name="open"
                                    class="input input-bordered bg-white w-full text-slate-800 font-semibold border-slate-600"
                                    readonly required>
                            </div>
                        </label>
                        <label for="" class="form-control w-full">
                            <div class="label">
                                <span class="label-text text-slate-50">Tanggal Tutup</span>
                            </div>
                            <div class="flex flex-col justify-center items-center gap-y-5">
                                <input type="text" id="addCloseDate" name="close"
                                    class="input input-bordered bg-white w-full text-slate-800 font-semibold border-slate-600"
                                    readonly required>
                            </div>
                        </label>
                    </div>
                </div>
                <button
                    class="w-full bg-green-600 text-slate-50 font-semibold mt-4 py-2.5 px-4 rounded-lg select-none hover:bg-green-700 active:scale-95 transition-all">
                    Add
                </button>
            </form>
            <div class="modal-action">
                <form method="dialog">
                    <button
                        class="bg-slate-600 text-slate-50 font-semibold py-2.5 px-4 rounded-lg select-none hover:bg-slate-500 active:scale-95 transition-all">Close</button>
                </form>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>
@endsection

@section('scripts')
    <script type="module">
        const calendar = minMaxDatePicker("#addOpenDate", '#addCloseDate', true);
    </script>
    <script type="module">
        console.log("[UpdateAvailableStock]");
        window.Echo.channel('update-available-stock').listen('UpdateAvailableStock', event => { 
            console.log("Stock ID:", event);
            const stock = event.availableStock;

            $(`#stock-red-${stock.id}`).text(`🔴 ${stock.red_relic_stock}`);
            $(`#stock-blue-${stock.id}`).text(`🔵 ${stock.blue_relic_stock}`);
            $(`#stock-purple-${stock.id}`).text(`🟣 ${stock.purple_relic_stock}`);
        });
    </script>
    <script>
        const addModal = $("#addModal");
        const formAdd = $("#formAdd");

        const openAddModal = () => {
            addModal[0].showModal();
        }
    </script>
    <script type="module">
        const resetModal = document.getElementById('resetModal');
        const openResetModalBtn = document.getElementById('openResetModalBtn');
        const cancelResetBtn = document.getElementById('cancelResetBtn');
        const confirmResetBtn = document.getElementById('confirmResetBtn');
        const resetInventoryForm = document.getElementById('resetInventoryForm');

        openResetModalBtn.addEventListener('click', () => {
            resetModal.showModal();
        });

        cancelResetBtn.addEventListener('click', () => {
            resetModal.close();
        });

        confirmResetBtn.addEventListener('click', () => {
            resetInventoryForm.submit();
        });
    </script>
@endsection
