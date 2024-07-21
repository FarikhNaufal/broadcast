<?php

namespace App\Livewire\MediaGroup;

use App\Models\Group;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $pagination = 5;
    public $orderBy = 'desc';
    public $search = '';

    #[Layout('app')]
    #[On('group-changed')]
    public function render()
    {
        return view('livewire.media-group.index', [
            'groups' => $this->getGroup(),
            'groupIsEmpty' => $this->groupIsEmpty(),
        ]);
    }

    public function getGroup(){
        return Group::where('name', 'like', '%' . $this->search . '%')->orderBy('created_at', $this->orderBy)->paginate($this->pagination);
    }

    public function groupIsEmpty(){
        return Group::count() == 0;
    }
}
