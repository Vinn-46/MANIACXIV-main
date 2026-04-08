<?php

use Illuminate\Support\Facades\Broadcast;
  use Illuminate\Support\Facades\Log;
/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('update-tears.{id}', function ($user, $id) {
    if (!$user || !isset($user->id)) {
        Log::warning('Unauthorized access attempt to update-tears channel by user: ' . json_encode($user));
        return false;
    }

    Log::info('User ' . $user->id . ' is authorized to access update-tears channel with ID: ' . $id);
    return (int) $user->id === (int) $id; 
});