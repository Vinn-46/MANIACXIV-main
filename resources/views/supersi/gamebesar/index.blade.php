@extends('supersi.layout.index', ['pageActive' => 'super-si.gamebesar', 'pageTitle' => 'Override Game Besar'])

@section('content')
    {{--  Breadcrumbs  --}}
    <div class="breadcrumbs text-sm mb-4">
        <ul>
            <li>
                <a href="{{ route('super-si.gamebesar.index') }}" class="font-medium text-slate-100">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="h-4 w-4 stroke-current mr-1">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                    </svg>
                    Override Poin Game Besar
                </a>
            </li>
        </ul>
    </div>

    {{--  Alerts  --}}
    @if (session()->has('updateSuccess'))
        <div role="alert" class="alert rounded-md bg-green-500 text-white border-none mt-2 mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session()->get('updateSuccess') }}</span>
        </div>
    @elseif(session()->has('error'))
        <div role="alert" class="alert rounded-md bg-red-500 text-white border-none mt-2 mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session()->get('error') }}</span>
        </div>
    @endif
    @if($errors->any())
        <div role="alert" class="alert rounded-md bg-red-500 text-white border-none mt-2 mb-4">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{--  Content  --}}
    <div class="flex flex-col justify-center content-center w-full bg-slate-400 p-4 rounded-md mt-4 shadow-lg">
        <h2 class="text-xl font-bold text-slate-900 mb-4 text-center">Tabel Override Poin Game Besar (Target Base)</h2>
        
        <div class="overflow-x-auto rounded bg-slate-500 p-2 shadow-inner">
            <table class="table w-full">
                <thead class="text-slate-100 bg-slate-700">
                    <tr style="font-size: 1.1rem;">
                        <th class="text-center py-3">ID</th>
                        <th class="text-center py-3">Team Name</th>
                        <th class="text-center py-3">Game Besar Points</th>
                        <th class="text-center py-3">Bonus Points</th>
                        <th class="text-center py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($players as $idx => $player)
                        <tr class="text-slate-100 font-medium border-b border-slate-600 hover:bg-slate-600 transition-colors" style="font-size: 0.95rem;">
                                <td class="text-center py-4">{{ $player->id }}</td>
                                <td class="text-center py-4 text-yellow-400 font-bold">{{ $player->team->name }}</td>
                                <td class="text-center py-4">
                                    <form action="{{ route('super-si.gamebesar.updatePoints', $player->id) }}" method="POST" class="inline-flex items-center justify-center gap-2">
                                        @csrf
                                        <input type="number" name="game_besar_points" value="{{ $player->game_besar_points }}" 
                                            class="input input-sm input-bordered bg-slate-700 text-white w-24 text-center" min="0">
                                </td>
                                <td class="text-center py-4">
                                        <input type="number" name="bonus_points" value="{{ $player->bonus_points }}" 
                                            class="input input-sm input-bordered bg-slate-700 text-white w-24 text-center" min="0">
                                </td>
                                <td class="text-center py-4">
                                        <button type="submit" class="bg-blue-600 text-slate-50 font-semibold py-1.5 px-4 rounded hover:bg-blue-500 active:scale-95 transition-all shadow-md">
                                            <i class="fa-solid fa-floppy-disk mr-1"></i> Save
                                        </button>
                                    </form>
                                </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
