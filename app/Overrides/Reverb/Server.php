<?php

namespace Laravel\Reverb\Protocols\Pusher;

use App\Events\SendDataEvent;
use App\Events\SetClientStatus;
use App\Models\Client;
use Exception;
use Illuminate\Support\Str;
use Laravel\Reverb\Contracts\Connection;
use Laravel\Reverb\Events\MessageReceived;
use Laravel\Reverb\Loggers\Log;
use Laravel\Reverb\Protocols\Pusher\Contracts\ChannelManager;
use Laravel\Reverb\Protocols\Pusher\Exceptions\InvalidOrigin;
use Laravel\Reverb\Protocols\Pusher\Exceptions\PusherException;

class Server
{
    /**
     * Create a new server instance.
     */
    public function __construct(protected ChannelManager $channels, protected EventHandler $handler)
    {
        //
    }

    /**
     * Handle the a client connection.
     */
    public function open(Connection $connection): void
    {

        // dd($connection);
        try {
            $this->verifyOrigin($connection);

            $connection->touch();

            $this->handler->handle($connection, 'pusher:connection_established');

            Log::info('Connection Established', $connection->id());
        } catch (Exception $e) {
            $this->error($connection, $e);
        }
    }

    /**
     * Handle a new message received by the connected client.
     */
    public function message(Connection $from, string $message): void
    {
        Log::info('Message Received', $from->id());
        Log::message($message);

        $from->touch();

        try {
            $event = json_decode($message, associative: true, flags: JSON_THROW_ON_ERROR);

            if ($event['event'] === 'updateWebsocketIdOnClientDB') {
                $data = $event['data'];
                $this->setWebsocketIdOnClientDB($from->id(), $data['clientID'], $data['agent']);

                Log::info('Client ID associated with WebSocket ID client_id:' . $data->clientID . 'websocket_id' . $from->id());
                return ;
            }

            match (Str::startsWith($event['event'], 'pusher:')) {
                true => $this->handler->handle(
                    $from,
                    $event['event'],
                    $event['data'] ?? [],
                    $event['channel'] ?? null
                ),
                default => ClientEvent::handle($from, $event)
            };

            Log::info('Message Handled', $from->id());

            MessageReceived::dispatch($from, $message);
        } catch (Exception $e) {
            $this->error($from, $e);
        }
    }

    /**
     * Handle a client disconnection.
     */
    public function close(Connection $connection): void
    {


        // $message = '...';

        try {
            $this->removeWebsocketIdOnClientDB($connection->id());
            // MessageReceived::dispatch($connection, $message);

        } catch (\Throwable $th) {
            Log::info('Connection Error Where Updating Client DB', $th);
        }
        $this->channels
            ->for($connection->app())
            ->unsubscribeFromAll($connection);

        $connection->disconnect();

        Log::info('Connection Closed', $connection->id());
    }

    /**
     * Handle an error.
     */
    public function error(Connection $connection, Exception $exception): void
    {
        if ($exception instanceof PusherException) {
            $connection->send(json_encode($exception->payload()));

            Log::error('Message from '.$connection->id().' resulted in a pusher error');
            Log::info($exception->getMessage());
            return;
        }

        $connection->send(json_encode([
            'event' => 'pusher:error',
            'data' => json_encode([
                'code' => 4200,
                'message' => 'Invalid message format',
            ]),
        ]));

        Log::error('Message from '.$connection->id().' resulted in an unknown error');
        Log::info($exception->getMessage());
    }

    /**
     * Verify the origin of the connection.
     *
     * @throws \Laravel\Reverb\Exceptions\InvalidOrigin
     */
    protected function verifyOrigin(Connection $connection): void
    {
        $allowedOrigins = $connection->app()->allowedOrigins();

        if (in_array('*', $allowedOrigins)) {
            return;
        }

        $origin = parse_url($connection->origin(), PHP_URL_HOST);

        if (! $origin || ! in_array($origin, $allowedOrigins)) {
            throw new InvalidOrigin;
        }
    }

    protected function setWebsocketIdOnClientDB($websocket_id, $clientID, $agent):void {
        $client = Client::findOrFail($clientID);
        $client->update([
            'websocket_id' => $websocket_id,
            'isActive' => 1,
            'agent' => $agent,
        ]);
        $message = $client->name . ' Aktif: ' . now();
        SendDataEvent::dispatch($client);
        SetClientStatus::dispatch('hello admin');
        wsActivityLog('Koneksi terhubung', $client, 'pulse', 'success', 'Websocket client telah aktif.');

    }

    protected function removeWebsocketIdOnClientDB($websocket_id): void {
        $client = Client::where('websocket_id', $websocket_id)->first();
        if (!$client) {
            return ;
        }
        $client->update([
            'websocket_id' => null,
            'isActive' => 0,
            'agent' => null
        ]);
        // $message = $client->name . ' Nonaktif: ' . now();
        SetClientStatus::dispatch('hello admin');
        wsActivityLog('Koneksi terputus', $client, 'pulse', 'yellow-500', 'Websocket client telah nonaktif atau terputus.');

    }
}
