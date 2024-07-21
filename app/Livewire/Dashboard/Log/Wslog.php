<?php

namespace App\Livewire\Dashboard\Log;

use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Activitylog\Models\Activity;

class Wslog extends Component
{

    #[On('client-changed')]
    public function render()
    {
        return view('livewire.dashboard.log.wslog',[
            'logs' => Activity::inLog('ws')->orderBy('created_at','desc')->paginate(50),
        ]);
    }
}
