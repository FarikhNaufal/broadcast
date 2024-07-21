<?php

namespace App\Livewire\ClientController;

use App\Events\GetClientDataEvent;
use App\Events\SendDataEvent;
use App\Models\Client;
use GuzzleHttp\Client as GuzzleHttpClient;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;

class RefreshEvent extends Component
{
    public $refreshEventModal = false;
    public Client $client;
    public $clientName;

    public function render()
    {
        return view('livewire.client-controller.refresh-event');
    }

    #[On('show-refresh-event-modal')]
    public function showModal($id, $name){
        $this->refreshEventModal = true;
        $this->clientName = $name;
        $this->setRefreshEvent($id);
    }

    public function setRefreshEvent($id){
        $this->client= Client::find($id);
    }

    public function refreshEvent(){

        $this->refreshEventModal = false;
        $this->dispatch('client-changed');
        $this->dispatch('show-toast', msg: 'Berhasil refresh ulang client...!');
        SendDataEvent::dispatch($this->client);
        

    }
}
