<?php

namespace App\Livewire\Dashboard;

use App\Models\Client;
use Livewire\Attributes\On;
use Livewire\Component;

class ClientStatus extends Component
{
    public $active;
    public $nonactive;

    public function mount()
    {
        $this->fetchClientData();
    }

    #[On('client-changed')]
    public function handleClientChanged()
    {
        $this->fetchClientData();
    }

    public function fetchClientData()
    {
        $this->active = Client::where('isActive', true)->get();
        $this->nonactive = Client::where('isActive', false)->get(['name']);
    }

    public function render()
    {
        return view('livewire.dashboard.client-status', [
            'active' => $this->active,
            'nonactive' => $this->nonactive
        ]);
    }
}
