<?php

namespace App\Livewire\Dashboard;

use App\Models\Client;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $orderBy = 'DESC';
    public $search = '';

    #[Layout('app')]
    #[On('dashboard-changed')]
    #[Lazy()]
    public function render()
    {
        return view('livewire.dashboard.index', [
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
        ->paginate(5);
    }


    public function clientIsEmpty(){
        return Client::count() == 0;
    }


}
