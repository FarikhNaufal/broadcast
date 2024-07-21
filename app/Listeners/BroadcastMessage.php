<?php

namespace App\Listeners;

use App\Events\SetClientStatus;
use App\Models\Client;
use Illuminate\Support\Facades\Log;
use Laravel\Reverb\Events\MessageReceived;

class BroadcastMessage
{
    /**
     * Create the event listener.
     */

    public function __construct()
    {
    }

    /**
     * Handle the event.
     */
    public function handle(MessageReceived $event): void
    {
        // dd($event);
        // $message = json_decode($event->message);
        // $data = $message->data;

        // if ($message->event === 'updateWebsocketIdOnClientDB') {
        //     SetClientStatus::dispatch($data);
        // }


        // if ($message->event === 'client-status') {
        //     $client = Client::find($data->clientID);
        //     if ($client) {
        //         $client->isActive = $data->isActive;
        //         $client->save();
        //     }
        //     SetClientStatus::dispatch($data);
        // }

    }


}
