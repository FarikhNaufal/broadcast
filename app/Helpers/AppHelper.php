<?php

use App\Events\GetDataEvent;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use Livewire\Livewire;
use Spatie\Activitylog\Facades\CauserResolver;



function wsActivityLog($event, $causer, $icon, $color, $msg) {
    activity('ws')
    ->causedBy($causer)
    ->event($event)
    ->withProperties([
        'icon' => $icon,
        'color' => $color,
    ])
    ->log($msg);
}

function activityLog($event, $icon, $color, $msg) {
    activity()
    ->causedBy(Auth::user())
    ->event($event)
    ->withProperties([
        'icon' => $icon,
        'color' => $color,
    ])
    ->log($msg);
}
