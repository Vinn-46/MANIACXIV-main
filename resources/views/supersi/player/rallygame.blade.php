@extends('supersi.layout.index', ['pageActive' => 'super-si.', 'pageTitle' => 'Rally Game Detail'])

@section('content')
    {{--  Breadcrumbs  --}}
    <div class="breadcrumbs text-sm">
        <ul>
            <li>
                <a href="{{ route('super-si.player.index') }}" class="font-medium">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        class="h-4 w-4 stroke-current mr-1">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z">
                        </path>
                    </svg>
                    Player
                </a>
            </li>
            <li>
                <span class="inline-flex items-center gap-2">
                    {{ $team->name ?? 'N/A' }}
                </span>
            </li>
        </ul>
    </div>
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
        @elseif(session()->has('deleteSuccess'))
            <div role="alert" class="alert rounded-md bg-green-300 border-none mt-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session()->get('deleteSuccess') }}</span>
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
    </div>

    {{--  Content  --}}
    <div class="flex flex-col justify-center content-center w-full bg-slate-500 p-3 rounded-md mt-4">
        {{--  Table  --}}
        <div class="overflow-auto rounded" style="max-height: 600px">
            <table class="table table-xs table-pin-cols table-pin-rows">
                <thead>
                    <tr class="text-slate-900 font-medium" style="font-size: 1.1rem;">
                        <th width="5%" class="text-center py-3">No</th>
                        <th width="15%" class="text-center py-3">Rally Game</th>
                        <th width="10%" class="text-center py-3">Type</th>
                        <th width="10%" class="text-center py-3">Points Earned</th>
                        <th width="20%" class="text-center py-3">Action</th>
                        <th width="20%" class="text-center py-3">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rallyGames as $index => $game)
                        @php
                            $score = $scores->get($game->id);
                        @endphp
                        <tr class="text-white font-medium text-sm" style="font-size: 0.9rem;">
                            <td width="5%" class="text-center py-4">{{ $index + 1 }}</td>
                            <td width="15%" class="text-center">{{ $game->name }}</td>
                            <td width="10%" class="text-center">{{ $game->type }}</td>

                            {{-- Points Earned --}}
                            <td width="10%" class="text-center">
                                @if ($score && $score->point)
                                    <span class="text-sky-300 font-semibold">{{ $score->point->value }}</span>
                                @else
                                    <span class="text-slate-400 italic">-</span>
                                @endif
                            </td>

                            {{-- Action (Create / Update) --}}
                            <td width="20%" class="text-center">
                                @if ($score)
                                    <button class="bg-yellow-600 text-white px-3 py-1 rounded hover:bg-yellow-700 transition-all" onclick="openUpdateModal({{ $score->id }})">
                                        Update
                                    </button>
                                @else
                                    <button class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 transition-all" onclick="openCreateModal({{ $player->id }}, {{ $game->id }})">
                                        Add
                                    </button>
                                @endif
                            </td>
                            {{-- Delete --}}
                            <td class="text-center">
                                @if ($score)
                                    <button class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 transition-all" onclick="openDeleteModal({{ $score->id }})">
                                        Delete
                                    </button>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{-- Create Score Modal --}}
    <dialog id="createScoreModal" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box bg-slate-800">
            <h3 class="text-lg font-bold text-white">Tambah Score</h3>
            <form action="" method="POST" id="formCreateScore">
                @csrf
                
                {{-- Pilih Point --}}
                <div class="form-control mt-4">
                    <label class="label">
                        <span class="label-text text-slate-50">Pilih Point</span>
                    </label>
                    <select name="point_id" class="select select-bordered bg-slate-700 text-white w-full" required>
                        @foreach ($points as $point)
                            <option value="{{ $point->id }}">Point {{ $point->value }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="w-full bg-green-600 text-slate-50 font-semibold mt-4 py-2.5 px-4 rounded-lg hover:bg-green-700 active:scale-95 transition-all">
                    Tambah Score
                </button>
            </form>

            <div class="modal-action">
                <form method="dialog">
                    <button class="bg-slate-600 text-slate-50 font-semibold py-2.5 px-4 rounded-lg hover:bg-slate-700 active:scale-95 transition-all">Tutup</button>
                </form>
            </div>
        </div>

        <form method="dialog" class="modal-backdrop">
            <button>Tutup</button>
        </form>
    </dialog>

    {{-- Update Score Modal --}}
    <dialog id="updateScoreModal" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box bg-slate-800">
            <h3 class="text-lg font-bold text-white">Update Score</h3>
            <form action="" method="POST" id="formUpdateScore">
                @csrf
                @method('PUT')

                {{-- Pilih Point --}}
                <div class="form-control mt-4">
                    <label class="label">
                        <span class="label-text text-slate-50">Pilih Point</span>
                    </label>
                    <select name="point_id" class="select select-bordered bg-slate-700 text-white w-full" required>
                        @foreach ($points as $point)
                            <option value="{{ $point->id }}" {{ isset($score) && $score->point_id == $point->id ? 'selected' : '' }}>
                                Point {{ $point->value }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="w-full bg-yellow-600 text-slate-50 font-semibold mt-4 py-2.5 px-4 rounded-lg hover:bg-yellow-700 active:scale-95 transition-all">
                    Update Score
                </button>
            </form>

            <div class="modal-action">
                <form method="dialog">
                    <button class="bg-slate-600 text-slate-50 font-semibold py-2.5 px-4 rounded-lg hover:bg-slate-700 active:scale-95 transition-all">Tutup</button>
                </form>
            </div>
        </div>

        <form method="dialog" class="modal-backdrop">
            <button>Tutup</button>
        </form>
    </dialog>

    {{-- Delete Score Modal --}}
    <dialog id="deleteScoreModal" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box bg-slate-800">
            <h3 class="text-lg font-bold text-white">Hapus Score</h3>
            <form action="" method="POST" id="formDeleteScore">
                @csrf
                @method('DELETE')



                <button type="submit" class="w-full bg-red-600 text-slate-50 font-semibold mt-4 py-2.5 px-4 rounded-lg hover:bg-red-700 active:scale-95 transition-all">
                    Hapus Score
                </button>
            </form>

            <div class="modal-action">
                <form method="dialog">
                    <button class="bg-slate-600 text-slate-50 font-semibold py-2.5 px-4 rounded-lg hover:bg-slate-700 active:scale-95 transition-all">Tutup</button>
                </form>
            </div>
        </div>

        <form method="dialog" class="modal-backdrop">
            <button>Tutup</button>
        </form>
    </dialog>
    <script>
    function openCreateModal(playerId, gameId) {
        console.log('playerId:', playerId, 'gameId:', gameId);
        const modal = document.getElementById('createScoreModal');
        const form = modal.querySelector('form');

        form.action = `/super-si/player/${playerId}/score/create/${gameId}`;
        modal.showModal();
    }

    function openUpdateModal(scoreId) {
        console.log('scoreId:', scoreId);
        const modal = document.getElementById('updateScoreModal');
        const form = modal.querySelector('form');

        form.action = `/super-si/player/score/update/${scoreId}`;
        modal.showModal();
    }

    function openDeleteModal(scoreId) {
        console.log('scoreId:', scoreId);
        const modal = document.getElementById('deleteScoreModal');
        const form = modal.querySelector('form');

        form.action = `/super-si/player/score/delete/${scoreId}`;
        modal.showModal();
    }
    </script>
@endsection