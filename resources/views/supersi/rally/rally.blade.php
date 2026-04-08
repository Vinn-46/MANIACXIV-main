@extends('supersi.layout.index', ['pageActive' => 'super-si.rally', 'pageTitle' => 'Rally Games Detail'])

@section('content')
    {{--  Breadcrumbs  --}}
    <div class="breadcrumbs text-sm">
        <ul>
            <li>
                <a href="{{ route('super-si.index') }}" class="font-medium">
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
                    Rally Games
                </a>
            </li>
            <li>
              <span class="inline-flex items-center gap-2">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    class="h-4 w-4 stroke-current">
                  <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                {{ $rallyGame->name }}
              </span>
            </li>
        </ul>
    </div>

    {{--  Alert  --}}
    <div>
        @if(session()->has('updateSuccess'))
            <div role="alert" class="alert rounded-md bg-green-300 border-none mt-2">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6 shrink-0 stroke-current"
                    fill="none"
                    viewBox="0 0 24 24">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{!! session()->get('updateSuccess') !!}</span>
            </div>
        @elseif(session()->has('deleteSuccess'))
            <div role="alert" class="alert rounded-md bg-red-300 border-none mt-2">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6 shrink-0 stroke-current"
                    fill="none"
                    viewBox="0 0 24 24">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{!! session()->get('deleteSuccess') !!}</span>
            </div>
        @elseif(session()->has('error'))
            <div role="alert" class="alert rounded-md bg-red-300 border-none mt-2">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6 shrink-0 stroke-current"
                    fill="none"
                    viewBox="0 0 24 24">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session()->get('error') }}</span>
            </div>
        @endif
        @error('point_id')
            <div role="alert" class="alert rounded-md bg-red-300 border-none mt-2">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6 shrink-0 stroke-current"
                    fill="none"
                    viewBox="0 0 24 24">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span><strong>{{ $message }}</strong></span>
            </div>
        @enderror
    </div>

    {{--  Content  --}}
    <div class="flex flex-col justify-center content-center w-full bg-slate-400 p-3 rounded-md mt-4">
        <div class="overflow-auto rounded" style="max-height: 450px">
            <table class="table table-xs table-pin-cols table-pin-rows">
                <thead>
                    <tr class="text-slate-900 font-medium" style="font-size: 1.1rem;">
                        <th width="20%" class="text-center py-3">Name</th>
                        <th width="20%" class="text-center">Score</th>
                        <th width="20%" class="text-center">Relic</th>
                        <th width="40%" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody id="tBody">
                @if(count($scores) != 0)
                    @foreach($scores as $score)
                        <tr class="text-slate-900 font-medium" style="font-size: 0.9rem;">
                            <td width="20%" class="text-center py-5">{{ $score->player->team->name }}</td>
                            <td width="20%" class="text-center">{{ $score->point }}</td>
                            <td width="20%" class="text-center">
                                   @php $relic = $score->relicChosen; @endphp
                                    @if ($relic)
                                        <span class="text-red-500 font-semibold">{{ $relic->red_relic_qty }} 🔴</span><br>
                                    @endif
                                    @if ($relic)
                                        <span class="text-purple-500 font-semibold">{{ $relic->purple_relic_qty }} 🟣</span><br>
                                    @endif
                                    @if ($relic)
                                        <span class="text-blue-500 font-semibold">{{ $relic->blue_relic_qty }} 🔵</span><br>
                                    @endif
                            </td>
                            <td class="" width="40%">
                                <div class="grid grid-cols-2 gap-3">
                                    <button
                                        class="bg-blue-600 text-slate-50 font-semibold py-2.5 rounded select-none hover:bg-blue-700 active:scale-95 transition-all"
                                        onclick="openUpdateModal('{{ $score->id }}')"
                                    >
                                        Update
                                    </button>
                                    <button
                                        class="bg-red-600 text-slate-50 font-semibold py-2.5 rounded select-none hover:bg-red-700 active:scale-95 transition-all"
                                        onclick="openDeleteModal('{{ $score->id }}')"
                                    >
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr><td colspan="3"><p class="font-medium text-lg text-slate-900 text-center">No Scores</p></td></tr>
                @endif
                </tbody>
            </table>
        </div>

        {{--      Pagination      --}}
        <div class="mt-6">
            {{ $scores->onEachSide(1)->withQueryString()->links('pagination::simple-tailwind') }}
        </div>
    </div>

    {{--  Update Modal  --}}
    <dialog id="updateModal" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box bg-slate-800">
            <h3 class="text-lg font-bold text-white">Update Score</h3>
            <form action="" method="POST" id="formUpdate">
                @csrf
                @method('PUT')

                {{-- Point Selector --}}
                <label class="form-control w-full rounded">
                    <div class="label">
                        <span class="label-text text-slate-50">Point</span>
                    </div>
                    <select class="select select-bordered rounded bg-slate-300 text-slate-800 font-medium" required name="point_id">
                        <option disabled selected>Pick one</option>
                        @foreach($points as $point)
                            <option value="{{ $point->id }}" {{ isset($score) && $point->id == $score->point_id ? 'selected' : '' }}>Point: {{ $point->point }} | Relics: {{ $point->relic_qty }}</option>
                        @endforeach
                    </select>
                </label>

                {{-- Relics Inputs --}}
                @php
                    $relic = isset($score) ? $score->relicChosen : null;
                @endphp
                <div class="grid grid-cols-3 gap-4 mt-4">
                    <div>
                        <label class="label text-slate-50">Red Relic</label>
                        <input
                            type="number"
                            min="0"
                            name="relics[red]"
                            value="{{ old('relics.red', $relic->red_relic_qty ?? 0) }}"
                            class="input input-bordered w-full text-black"
                        />
                    </div>
                    <div>
                        <label class="label text-slate-50">Purple Relic</label>
                        <input
                            type="number"
                            min="0"
                            name="relics[purple]"
                            value="{{ old('relics.purple', $relic->purple_relic_qty ?? 0) }}"
                            class="input input-bordered w-full text-black"
                        />
                    </div>
                    <div>
                        <label class="label text-slate-50">Blue Relic</label>
                        <input
                            type="number"
                            min="0"
                            name="relics[blue]"
                            value="{{ old('relics.blue', $relic->blue_relic_qty ?? 0) }}"
                            class="input input-bordered w-full text-black"
                        />
                    </div>
                </div>

                {{-- Checkbox Options --}}
                <div class="form-control mt-4">
                    <label class="label cursor-pointer justify-start gap-2">
                        <input type="checkbox" class="checkbox checkbox-sm" name="check_session_stock" checked />
                        <span class="label-text text-slate-50">Cek stok sesi GameBesar</span>
                    </label>
                    <label class="label cursor-pointer justify-start gap-2">
                        <input type="checkbox" class="checkbox checkbox-sm" name="add_back_session_stock" checked />
                        <span class="label-text text-slate-50">Tambah kembali stok sesi jika diubah</span>
                    </label>
                </div>

                {{-- Submit Button --}}
                <button class="w-full bg-green-600 text-slate-50 font-semibold mt-4 py-2.5 px-4 rounded-lg hover:bg-green-700 active:scale-95 transition-all">
                    Update
                </button>
            </form>

            <div class="modal-action">
                <form method="dialog">
                    <button class="bg-slate-600 text-slate-50 font-semibold py-2.5 px-4 rounded-lg hover:bg-slate-500 active:scale-95 transition-all">Close</button>
                </form>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>

    {{--  Delete Modal --}}
    <dialog id="deleteModal" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box bg-slate-800">
            <h3 class="text-lg font-bold text-white">Delete Score</h3>
            <form action="" method="POST" id="formDelete">
                @csrf
                @method('DELETE')

                {{-- Option: Return Relics to Session --}}
                <div class="form-control mt-4">
                    <label class="label cursor-pointer justify-start gap-2">
                        <input type="checkbox" class="checkbox checkbox-sm" name="add_back_session_stock" checked />
                        <span class="label-text text-slate-50">Tambah kembali stok sesi GameBesar</span>
                    </label>
                </div>

                <button class="w-full bg-red-600 text-slate-50 font-semibold mt-4 py-2.5 px-4 rounded-lg hover:bg-red-700 active:scale-95 transition-all">
                    Delete
                </button>
            </form>

            <div class="modal-action">
                <form method="dialog">
                    <button class="bg-slate-600 text-slate-50 font-semibold py-2.5 px-4 rounded-lg hover:bg-slate-700 active:scale-95 transition-all">Close</button>
                </form>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>
@endsection

@section('scripts')
    <script>
        const rallyId = '{{ $rallyGame->id }}';
        const updateModal = $("#updateModal");
        const formUpdate = $("#formUpdate");
        const deleteModal = $("#deleteModal");
        const formDelete = $("#formDelete");

        const openUpdateModal = (id) => {
            let url = `{{ route('super-si.index') }}/rallyGame/${rallyId}/${id}/score/update`;
            formUpdate.attr('action', url);
            updateModal[0].showModal();
        }

        const openDeleteModal = (id) => {
            let url = `{{ route('super-si.index') }}/rallyGame/${rallyId}/${id}/score/delete`;
            formDelete.attr("action", url);
            deleteModal[0].showModal();
        }
    </script>
@endsection
