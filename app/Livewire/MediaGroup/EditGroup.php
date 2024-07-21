<?php

namespace App\Livewire\MediaGroup;

use App\Events\SendDataEvent;
use App\Livewire\Forms\GroupForm;
use App\Models\Group;
use App\Models\Media;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class EditGroup extends Component
{
    public GroupForm $form;
    public $editGroupModal = false;
    public $medias;

    #[Validate('required')]
    public $options = [];

    public function mount(){
        $this->medias = Media::all();
    }


    #[On('show-edit-group-modal')]
    public function setGroup(Group $id){
        $this->editGroupModal = true;
        $this->form->setGroup($id);
    }


    public function updateGroup(){

        $this->form->update($this->options);
        $this->editGroupModal = false;
        $this->dispatch('group-changed');
        $this->dispatch('show-toast', msg: 'Group Media berhasil diperbarui...!');
        $clients = $this->form->group->clients;
        foreach ($clients as $client) {
            SendDataEvent::dispatch($client);
        }
    }

    public function addOption(){
        $this->form->addOption();
    }

    public function removeOption($index){
        $this->form->removeOption($index);
    }


    public function render()
    {
        return view('livewire.media-group.edit-group');
    }
}
