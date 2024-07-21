<?php

namespace App\Livewire\Client;

use App\Models\Media;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{

    public $name;
    public $media = [];
    public $group = [];
    public $client;

    public function mount(){
        $this->client = Auth::guard('client')->user();
        $this->setClient();
    }

    #[Layout('client')]
    public function render()
    {
        return view('livewire.client.index');
    }

    // public function getListeners()
    // {
    //     return [
    //         "echo-private:{$this->client->id},SendDataEvent" => 'setClient',
    //     ];
    // }

    //diatas , lalu log dipisah, lalu dashboard

    public function setClient(){
        $this->name = $this->client->name;
        if ($this->client->usingGroup()) {
            $this->group = $this->client->group;
        } else {
            $this->media = $this->client->media;
        }
    }
}
