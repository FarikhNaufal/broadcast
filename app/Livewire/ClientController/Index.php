<?php

namespace App\Livewire\ClientController;

use App\Events\SendDataEvent;
use App\Models\Client;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $orderBy = 'DESC';
    public $pagination = 5;
    public $search = '';

    #[Layout('app')]
    #[On('client-changed')]
    public function render()
    {
        return view('livewire.client-controller.index', [
            'clients' => $this->getClients(),
            'clientIsEmpty' => $this->clientIsEmpty(),
        ]);
    }

    public function getClients(){
        $search = $this->search;
        $orderBy = $this->orderBy;
        return Client::where('name', 'like', "%{$search}%")
        ->orWhereHas('media', function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%");
        })
        ->orderBy('created_at', $orderBy)
        ->paginate($this->pagination);
    }

    public function clientIsEmpty(){
        return Client::count() == 0;
    }

    public function refreshAll(){
        $clients = Client::all();
        foreach ($clients as $client) {
            SendDataEvent::dispatch($client);
        }

        $this->dispatch('show-toast', msg: 'Berhasil refresh ulang semua client...!');
    }
}
