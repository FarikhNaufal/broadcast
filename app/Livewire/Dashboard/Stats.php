<?php

namespace App\Livewire\Dashboard;

use App\Models\Client;
use App\Models\Group;
use App\Models\Media;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class Stats extends Component
{
    public $group, $media, $client, $session;



    #[On('dashboard-changed')]
    #[On('client-changed')]
    public function render()
    {
        $this->group = Group::count();
        $this->media = Media::count();
        $this->client = Client::count();
        $this->session = Client::where('isActive', true)->count();
        return view('livewire.dashboard.stats');
    }
}
