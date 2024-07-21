<?php

namespace App\Livewire\Dashboard\Log;

use Livewire\Component;
use Spatie\Activitylog\Models\Activity;

class Systemlog extends Component
{
    public function render()
    {
        return view('livewire.dashboard.log.systemlog',[
            'logs' => Activity::inLog('default')->orderBy('created_at','desc')->paginate(50),
        ]);
    }
}
