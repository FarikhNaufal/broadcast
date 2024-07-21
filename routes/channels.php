<?php

use Illuminate\Support\Facades\Broadcast;

// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });

// Broadcast::channel('Client.{clientID}', function () {
//     return true;
// }, ['guards' => [ClientMiddleware::class]]);

Broadcast::channel('{clientID}', function () {
    return true;
}, ['guards' => ['client']]);

Broadcast::channel('test', function (){
    return true;
});

Broadcast::channel('status-channel', function(){
    return true;
});


