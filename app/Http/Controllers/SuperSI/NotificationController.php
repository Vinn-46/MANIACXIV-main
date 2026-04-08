<?php

namespace App\Http\Controllers\SuperSI;

use App\Models\Score;
use App\Models\Player;
use App\Models\Mission;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::with('rallyGame')
            ->where('resolved', false)
            ->orderBy('called_at', 'desc')
            ->get();

        return view('supersi.notification.index', compact('notifications'));
    }

    public function resolve(Request $request, Notification $notification)
    {
        $notification->update(['resolved' => true]);
        return redirect()->route('super-si.notification.index');
    }
}
