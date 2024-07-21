<?php

namespace App\Livewire\ClientController;

use App\Events\NoDataEvent;
use App\Models\Client;
use Livewire\Attributes\On;
use Livewire\Component;

class DeleteClient extends Component
{
    public $showDeleteClientModal = false;
    public $clientName;
    public $clientID;


    public function render()
    {
        return view('livewire.client-controller.delete-client');
    }

    #[On('show-delete-client-modal')]
    public function showModal($id, $name){
        $this->clientName = $name;
        $this->clientID = $id;
        $this->showDeleteClientModal = true;

    }

    public function delete(){
        $client = Client::findOrFail($this->clientID);
        NoDataEvent::dispatch($client, true);

        activityLog('Client', 'pulse', 'yellow-500', 'Berhasil menghapus client: '. $this->clientName);
        if ($client->delete()) {
            $this->dispatch('client-changed');
            $this->dispatch('show-toast', msg: 'Berhasil menghapus client...!');
        }
        $this->showDeleteClientModal = false;
    }
}
