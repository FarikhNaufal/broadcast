<?php

namespace App\Livewire\MediaGroup;

use App\Events\NoDataEvent;
use App\Models\Group;
use Livewire\Attributes\On;
use Livewire\Component;

class DeleteGroup extends Component
{
    public $showDeleteGroupModal = false;
    public $groupName;
    public $groupID;

    public function render()
    {
        return view('livewire.media-group.delete-group');
    }

    #[On('show-delete-group-modal')]
    public function showModal($id, $name){
        $this->groupName = $name;
        $this->groupID = $id;
        $this->showDeleteGroupModal = true;

    }
    public function delete(){
        $group = Group::findOrFail($this->groupID);
        $clients = $group->clients;
        foreach ($clients as $client) {
            NoDataEvent::dispatch($client);
        }


        activityLog('MediaGroup', 'package', 'purple-500', 'Berhasil menghapus group: '. $this->groupName);
        if ($group->delete()) {
            $this->dispatch('group-changed');
            $this->dispatch('show-toast', msg: 'Group Media berhasil dihapus...!');
        }
        $this->showDeleteGroupModal = false;
    }

}
