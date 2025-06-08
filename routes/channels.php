<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('new-appointment', function ($user) {
    return $user && $user->role != 'doctor';
});
