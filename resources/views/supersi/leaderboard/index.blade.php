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
        <div class="bg-slate-500 w-full mb-5 rounded p-4">
            <h1
                class="text-center bg-slate-900 text-slate-100 mb-5 rounded py-3 text-lg font-semibold"
            >
                Summarize Semifinal Score For Final
            </h1>
            <div class="grid grid-cols-1 gap-y-4 md:gap-y-2 xl:grid-cols-3">
                <div class="select2-container flex justify-center">
                    <label for="" class="mr-5 font-medium">Choose Contest: </label>
                    <select class="js-example-basic-single" name="contest" id="contest-select" required>
                        <option selected disabled>-- Pick One --</option>
                        @foreach($contests as $contest)
                            <option value="{{ $contest->id }}">{{ $contest->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button
                    class="bg-slate-900 text-slate-50 font-semibold py-2 px-5 rounded hover:bg-slate-700 active:scale-95 transition-all xl:col-start-3 xl:col-end-4"
                    id="btnSummarize"
                >
                    Summarize
                </button>
            </div>
        </div>

        {{--    Table    --}}
        <div class="overflow-auto rounded">
            <h1 class="text-center font-bold text-xl py-2">Leaderboard Rally and Game Besar</h1>
            <div class="overflow-auto rounded" style="max-height: 450px">
                <table>
                    <thead>
                        <tr>
                            <th style="padding: 8px 12px; border-bottom: 1px solid white;">Rank</th>
                            <th style="padding: 8px 12px; border-bottom: 1px solid white;">Player ID</th>
                            <th style="padding: 8px 12px; border-bottom: 1px solid white;">Team Name</th>
                            <th style="padding: 8px 12px; border-bottom: 1px solid white; border-left: 2px solid white;">Rally Tears</th>
                            <th style="padding: 8px 12px; border-bottom: 1px solid white;">Rally Win</th>
                            <th style="padding: 8px 12px; border-bottom: 1px solid white;">Rally Played</th>
                            <th style="padding: 8px 12px; border-bottom: 1px solid white;">Rally Point</th>
                            <th style="padding: 8px 12px; border-bottom: 1px solid white; border-left: 2px solid white;">Game Besar Point</th>
                            <th style="padding: 8px 12px; border-bottom: 1px solid white; border-left: 2px solid white;">Total</th>
                            <th style="padding: 8px 12px; border-bottom: 1px solid white; border-left: 2px solid white;">Convert Tears Game Besar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($leaderboard as $idx => $row)
                            <tr>
                                <td style="padding: 8px 12px;">{{ $idx + 1 }}</td>
                                <td style="padding: 8px 12px;">{{ $row->player_id }}</td>
                                <td style="padding: 8px 12px;">{{ $row->team_name }}</td>
                                <td style="padding: 8px 12px; border-left: 2px solid white;">{{ $row->r_tears }}</td>
                                <td style="padding: 8px 12px;">{{ $row->r_jumlah_pos_win }}</td>
                                <td style="padding: 8px 12px;">{{ $row->r_jumlah_pos_dimainkan }}</td>
                                <td style="padding: 8px 12px;">{{ $row->point_rally }}</td>
                                <td style="padding: 8px 12px; border-left: 2px solid white;">{{ $row->gb_points }}</td>
                                <td style="padding: 8px 12px; border-left: 2px solid white;"><b>{{ $row->total_score }}</b></td>
                                <td style="padding: 8px 12px; border-left: 2px solid white;">{{ $row->converted_points }}</td>
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
        $(document).ready(function() {
            $("#contest-select").select2();
        });

        $(document).ready(function () {
            $('#btnSummarize').click(function () {
                const contest_id = $('#contest-select').val();

                if (!contest_id) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        text: 'Please select a contest first.',
                    });
                    return;
                }

                $.ajax({
                    url: "{{ route('super-si.summarize') }}",
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        contest_id: contest_id,
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
                        csvRows.push(headers.join(','));

                        // Add data rows
                        scores.forEach(row => {
                            const values = headers.map(header => {
                                // Escape quotes and commas inside values
                                let val = row[header] ?? '';
                                if (typeof val === 'string') {
                                    val = val.replace(/"/g, '""'); // Escape quotes
                                    if (val.includes(',') || val.includes('\n')) {
                                        val = `"${val}"`;
                                    }
                                }
                                return val;
                            });
                            csvRows.push(values.join(','));
                        });

                        // Create downloadable CSV file
                        const csvString = csvRows.join('\n');
                        const blob = new Blob([csvString], { type: 'text/csv' });
                        const url = URL.createObjectURL(blob);
                        const link = document.createElement('a');
                        link.href = url;
                        link.download = `summary_contest_${contest_id}_${new Date().toISOString().slice(0,10)}.csv`;
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
