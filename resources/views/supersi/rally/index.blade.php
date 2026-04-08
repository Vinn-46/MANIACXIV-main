@extends('supersi.layout.index', ['pageActive' => 'super-si.rally', 'pageTitle' => 'Rally Games'])

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
        </ul>
    </div>

    {{--  Content  --}}
    <div class="flex flex-col justify-center content-center w-full bg-slate-400 p-3 rounded-md mt-4">
        <div class="overflow-auto rounded" style="max-height: 600px">
            <table class="table table-xs table-pin-cols table-pin-rows">
                <thead>
                    <tr class="text-slate-900 font-medium" style="font-size: 1.1rem;">
                        <th width="5%" class="text-center py-3">No</th>
                        <th width="25%" class="text-center">Rally Games</th>
                        <th width="10%" class="text-center">Type</th>
                        <th width="25%" class="text-center">Penpos</th>
                        <th width="10%" class="text-center">Times Played</th>
                        <th width="10%" class="text-center sticky right-0 z-10">Action</th>
                    </tr>
                </thead>
                <tbody id="tBody">
                    @foreach($rallyGames as $no => $rg)
                        <tr class="text-slate-900 font-medium" style="font-size: 0.9rem;">
                            <td width="5%" class="text-center py-5">{{ $no + 1 }}</td>
                            <td width="25%" class="text-center">{{ $rg->name }}</td>
                            <td width="10%" class="text-center">{{ $rg->type }}</td>
                            <td width="25%" class="text-center">{{ $rg->user->username }}</td>
                            <td width="10%" class="text-center">{{ $rg->scores_count }}</td>
                            <td width="10%" class="text-center sticky right-0 bg-slate-400 z-5">
                                <button
                                    class="bg-slate-900 text-slate-50 font-semibold py-2 px-3 rounded hover:bg-slate-700 active:scale-95 transition-all"
                                    onclick="window.location = '{{ route('super-si.index') }}/rallyGame/{{ $rg->id }}'"
                                >
                                    Show
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
