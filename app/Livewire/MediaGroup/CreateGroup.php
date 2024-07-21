<?php

namespace App\Livewire\MediaGroup;

use App\Livewire\Forms\GroupForm;
use App\Models\Media;
use Livewire\Attributes\On;
use Livewire\Component;

class CreateGroup extends Component
{
    public GroupForm $form;

    public function render()
    {
        return view('livewire.media-group.create-group',[
            'medias' => $this->getMedia(),
        ]);
    }

    public function mount(){
        $this->form->addOption();
    }

    public function storeGroup(){
        $this->form->store();
        $this->dispatch('group-changed');
        $this->dispatch('show-toast', msg: 'Group Media Baru berhasil ditambahkan...!');
        $this->dispatch('close-create-group-modal');
        $this->resetForm();
    }

    public function getMedia(){
        return Media::latest()->get(['id', 'name']);
    }

    #[On('closeGroupModal')]
    public function closeModal(){
        $this->resetForm();
    }

    public function resetForm(){
        $this->reset(['form.name','form.options']);
        $this->addOption();
        $this->resetValidation();
    }

    public function addOption(){
        $this->form->addOption();
    }

    public function removeOption($index){
        $this->form->removeOption($index);
    }


}

