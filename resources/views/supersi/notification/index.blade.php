@extends('supersi.layout.index', ['pageActive' => 'super-si.notifications', 'pageTitle' => 'SI Notifications'])

@section('content')
    {{--  Breadcrumbs  --}}
    <div class="breadcrumbs text-sm">
        <ul>
            <li>
                <a href="{{ route('super-si.index') }}" class="font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="h-4 w-4 stroke-current mr-1">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                    </svg>
                    Notifications
                </a>
            </li>
        </ul>
    </div>

    {{-- Notification Table --}}
    <div class="flex flex-col justify-center content-center w-full bg-slate-400 p-3 rounded-md mt-4">
        <div class="overflow-auto rounded" style="max-height: 600px">
            <table class="table table-xs table-pin-cols table-pin-rows">
                <thead>
                    <tr class="text-slate-900 font-medium" style="font-size: 1.1rem;">
                        <th class="text-center py-3">No</th>
                        <th class="text-center">Rally Game</th>
                        <th class="text-center">Type</th>
                        <th class="text-center">Penpos</th>
                        <th class="text-center">Called At</th>
                        <th class="text-center sticky right-0 z-10">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($notifications as $index => $notif)
                        <tr class="text-slate-900 font-medium" style="font-size: 0.9rem;">
                            <td class="text-center py-4">{{ $index + 1 }}</td>
                            <td class="text-center">{{ $notif->rallyGame->name }}</td>
                            <td class="text-center">{{ ucfirst($notif->rallyGame->type) }}</td>
                            <td class="text-center">{{ $notif->rallyGame->user->username }}</td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($notif->called_at)->format('d M Y H:i:s') }}</td>
                            <td class="text-center sticky right-0 bg-slate-400 z-5">
                                <button type="button" onclick="openResolveModal({{ $notif->id }})" class="bg-green-600 text-white font-semibold py-1 px-3 rounded hover:bg-green-700 active:scale-95 transition-all">
                                    OK
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-slate-600 py-6">No active notifications.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <dialog id="resolveModal" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box bg-slate-800">
            <h3 class="text-lg font-bold text-white">Tandai Selesai</h3>
            <p class="text-slate-50 mt-2">Yakin ingin menandai notifikasi ini sebagai <strong>selesai</strong>?</p>

            <form method="POST" id="resolveForm">
                @csrf
                @method('PATCH')
                <button type="submit" class="w-full bg-green-600 text-white font-semibold mt-4 py-2.5 px-4 rounded-lg hover:bg-green-700 active:scale-95 transition-all">
                    Ya, Selesaikan
                </button>
            </form>

            <div class="modal-action">
                <form method="dialog">
                    <button class="bg-slate-600 text-slate-50 font-semibold py-2.5 px-4 rounded-lg hover:bg-slate-700 active:scale-95 transition-all">
                        Batal
                    </button>
                </form>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>
    <script>
        window.openResolveModal = function(notificationId) {
            const modal = document.getElementById('resolveModal');
            const form = document.getElementById('resolveForm');
    
            form.action = `/super-si/notification/${notificationId}/resolve`;
            modal.showModal();
        }
    </script>
@endsection