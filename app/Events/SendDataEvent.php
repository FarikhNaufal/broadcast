<?php

namespace App\Events;

use App\Models\Client;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendDataEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $clientId;
    public $clientName;
    public $media;
    public $status;

    public function __construct(Client $client)
    {
        $this->clientId = $client->id;
        $this->clientName = $client->name;
        $this->status = now()->timezone('Asia/Bangkok')->format('H:i:s.u');
        if ($client->usingGroup()) {
            $this->media = $client->group->media->map(function ($media) {
                return [
                    'name' => $media->name,
                    'type' => $media->type,
                    'data' => $media->data,
                    'duration' => $media->pivot->duration,
                ];
            })->values()->all();
        } else {
            $this->media = $client->media->map(function ($media) {
                return [
                    'name' => $media->name,
                    'type' => $media->type,
                    'data' => $media->data,
                    'duration' => $media->pivot->duration,
                ];
            })->values()->all();
        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel($this->clientId);
    }
}
