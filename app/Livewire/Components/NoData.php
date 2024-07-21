<?php

namespace App\Livewire\Components;

use Livewire\Component;

class NoData extends Component
{
    public $data;
    public function render()
    {
        return view('livewire.components.no-data');
    }
}
