@extends('supersi.layout.index', ['pageActive' => 'super-si.leaderboard', 'pageTitle' => 'Leaderboard Semifinal'])

@section('cdn')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('styles')
    <style>
        .select2-container.select2-container--default .select2-selection--multiple {
            height: 39px;
            --border-opacity: 1 !important;
            border-color: #e2e8f0 !important;
            border-color: rgba(226, 232, 240, var(--border-opacity)) !important;
        }

        .select2-container.select2-container--default .select2-selection--multiple .select2-selection__choice {
            height: 26px;
            display: flex;
            align-items: center;
            margin-top: 0;
            --bg-opacity: 1;
            background-color: #edf2f7;
            background-color: rgba(237, 242, 247, var(--bg-opacity));
            --border-opacity: 1;
            border-color: #e2e8f0;
            border-color: rgba(226, 232, 240, var(--border-opacity));
            padding-right: 0.5rem;
            margin-right: 0.5rem;
        }

        .select2-container.select2-container--default .select2-selection--multiple .select2-selection__choice:first-child {
            margin-left: -0.25rem;
        }

        .select2-container.select2-container--default .select2-selection--multiple .select2-selection__choice .select2-selection__choice__remove {
            margin-left: 0.25rem;
            margin-right: 0.5rem;
        }

        .select2-container.select2-container--default .select2-search--dropdown .select2-search__field {
            --border-opacity: 1;
            border-color: #e2e8f0;
            border-color: rgba(226, 232, 240, var(--border-opacity));
        }

        .select2-container.select2-container--default .select2-results__option {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }

        .select2-container.select2-container--default .select2-results__option--highlighted[aria-selected] {
            --bg-opacity: 1;
            background-color: #e2e8f0;
            color: #0f172a;
            font-weight: 500;
            /*background-color: #1C3FAA;*/
            /*background-color: rgba(28, 63, 170, var(--bg-opacity));*/
        }

        .select2-container--default .select2-results__option--selected {
            background-color: #cbd5e1 !important;
            color: #0f172a;
            font-weight: 500;
        }

        .select2-container .select2-selection.select2-selection--single {
            height: 39px;
            --border-opacity: 1;
            border-color: #e2e8f0;
            border-color: rgba(226, 232, 240, var(--border-opacity));
        }

        .select2-container .select2-selection .select2-selection__rendered {
            height: 100%;
            display: flex;
            align-items: center;
            padding-left: 0.75rem;
            padding-right: 2rem;
        }

        .select2-container .select2-selection .select2-selection__arrow {
            width: 32px;
            height: 100%;
        }

        .select2-container .select2-dropdown {
            --border-opacity: 1;
            border-color: #e2e8f0;
            border-color: rgba(226, 232, 240, var(--border-opacity));
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            font-weight: 600 !important;
        }

        div:where(.swal2-container) div:where(.swal2-popup) {
            background-color: #334155;
            color: #e2e8f0;
        }

        button, [type='button'], [type='reset'], [type='submit'] {
            background-color: #1e293b;
            color: #e2e8f0;
        }
    </style>
@endsection

@section('content')
    {{--  Breadcrumbs  --}}
    <div class="breadcrumbs text-sm">
        <ul>
            <li>
                <a href="{{ route('super-si.leaderboard.index') }}" class="font-medium">
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
                    Leaderboard
                </a>
            </li>
        </ul>
    </div>

    {{--  Content  --}}
    <div class="flex flex-col justify-center content-center w-full bg-slate-400 p-3 rounded-md mt-4">
        {{--    Summarize    --}}
        <div class="bg-slate-500 w-full mb-5 rounded p-4 flex flex-col items-center">
            <h1
                class="text-center bg-slate-900 text-slate-100 mb-5 rounded py-3 px-6 w-full text-lg font-semibold"
            >
                Export Leaderboard (CSV)
            </h1>
            <button
                class="bg-green-600 text-slate-50 font-semibold py-2 px-8 rounded hover:bg-green-500 active:scale-95 transition-all text-lg"
                id="btnSummarize"
            >
                <i class="fa-solid fa-file-excel mr-2"></i> Export Rekap
            </button>
        </div>

        <div class="rounded-lg shadow-2xl mb-4">
            <h1 class="text-center font-bold text-2xl py-4 bg-slate-800 text-white rounded-t-lg border-b border-slate-700 tracking-wide">
                <i class="fa-solid fa-trophy text-amber-400 mr-2"></i> Leaderboard Rally and Game Besar
            </h1>
            <div class="overflow-auto bg-slate-700/40 rounded-b-lg backdrop-blur-sm" style="max-height: 500px">
                <table class="w-full text-left border-collapse">
                    <thead style="position: sticky; top: 0; z-index: 10;" class="bg-slate-800 text-slate-200 shadow-md">
                        <tr class="text-xs uppercase tracking-wider">
                            <th class="py-4 px-3 font-semibold text-center border-b border-slate-600">Rank</th>
                            <th class="py-4 px-3 font-semibold text-center border-b border-slate-600">Team Name</th>
                            <th class="py-4 px-3 font-semibold text-center border-b border-slate-600">Lifetime Honor</th>
                            <th class="py-4 px-3 font-semibold text-center border-b border-slate-600">Pos (Win/Play)</th>
                            <th class="py-4 px-3 font-semibold text-center border-b border-slate-600">Rally Score</th>
                            <th class="py-4 px-3 font-semibold text-center border-b border-slate-600">Gamebes Pts</th>
                            <th class="py-4 px-3 font-semibold text-center border-b border-slate-600">Gamebes Score</th>
                            <th class="py-4 px-3 font-bold text-center border-b border-slate-600 bg-slate-900 border-l border-slate-700 text-amber-400">Final Score</th>
                        </tr>
                    </thead>
                    <tbody class="text-slate-900 text-sm bg-slate-100">
                        @foreach($leaderboard as $idx => $row)
                            <tr class="hover:bg-slate-200 transition-all duration-200 border-b border-slate-300 last:border-0 group">
                                <td class="py-3 px-3 text-center font-medium">
                                    <span class="bg-slate-300 text-slate-800 px-2 py-1 rounded text-xs group-hover:bg-slate-400">{{ $idx + 1 }}</span>
                                </td>
                                <td class="py-3 px-3 text-center font-bold text-slate-900 text-base tracking-wide">{{ $row->team_name }}</td>
                                <td class="py-3 px-3 text-center">{{ number_format($row->total_honor) }}</td>
                                <td class="py-3 px-3 text-center text-slate-700">{{ $row->pos_menang }} <span class="mx-1 text-slate-400">/</span> {{ $row->pos_dimainkan }}</td>
                                <td class="py-3 px-3 text-center font-medium">{{ number_format($row->rally_score) }}</td>
                                <td class="py-3 px-3 text-center font-medium">{{ number_format($row->gamebes_poin) }}</td>
                                <td class="py-3 px-3 text-center font-medium">{{ number_format($row->gamebes_score) }}</td>
                                <td class="py-3 px-3 text-center border-l border-slate-300 bg-slate-200 group-hover:bg-slate-300 transition-colors">
                                    <span class="text-lg font-extrabold text-slate-900 drop-shadow-sm">{{ number_format($row->total_score) }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('#btnSummarize').click(function () {
                $.ajax({
                    url: "{{ route('super-si.summarize') }}",
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function (res) {
                        const scores = res.scores;

                        if (!scores.length) {
                            Swal.fire('No Data', 'No scores found for the selected contest.', 'info');
                            return;
                        }

                        // Prepare CSV content
                        const headers = Object.keys(scores[0]);
                        const csvRows = [];

                        // Add header row
                        csvRows.push(headers.join(';'));

                        // Add data rows
                        scores.forEach(row => {
                            const values = headers.map(header => {
                                // Escape quotes and semicolons inside values
                                let val = row[header] ?? '';
                                if (typeof val === 'string') {
                                    val = val.replace(/"/g, '""'); // Escape quotes
                                    if (val.includes(';') || val.includes('\n')) {
                                        val = `"${val}"`;
                                    }
                                }
                                return val;
                            });
                            csvRows.push(values.join(';'));
                        });

                        // Create downloadable CSV file
                        const csvString = "sep=;\n" + csvRows.join('\n');
                        const blob = new Blob([csvString], { type: 'text/csv' });
                        const url = URL.createObjectURL(blob);
                        const link = document.createElement('a');
                        link.href = url;
                        link.download = `rekap_leaderboard_semifinal_${new Date().toISOString().slice(0,10)}.csv`;
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                        URL.revokeObjectURL(url);

                        Swal.fire('Success', 'CSV summary has been downloaded.', 'success');
                    },
                    error: function (xhr) {
                        Swal.fire('Error', 'Failed to fetch summary. Try again.', 'error');
                        console.error(xhr);
                    }
                });
            });
        });
    </script>
@endsection
