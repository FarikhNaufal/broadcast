<?php

namespace App\Livewire\ClientController;

use App\Livewire\Forms\ClientForm;
use App\Models\Group;
use App\Models\Media;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateClient extends Component
{
    public ClientForm $form;

    public function render()
    {
        return view('livewire.client-controller.create-client',[
            'medias' => $this->getMedia(),
            'groups' => $this->getGroup(),
        ]);
    }

    public function mount()
    {
        $this->form->addOption();
    }

    public function storeClient(){
        $this->form->store();
        $this->dispatch('client-changed');
        $this->dispatch('show-toast', msg: 'Client baru berhasil ditambahkan...!');
        $this->dispatch('close-create-client-modal');
        $this->resetForm();
    }

    public function getMedia(){
        return Media::latest()->get(['id', 'name']);
    }

    public function getGroup(){
        return Group::latest()->get(['id', 'name']);
    }

    #[On('closeClientModal')]
    public function closeModal(){
        $this->resetForm();
    }

    public function resetForm(){
        $this->reset(['form.name', 'form.password', 'form.options', 'form.usingGroup', 'form.groupID']);
        $this->addOption();
        $this->resetValidation();
    }

    public function addOption(){
        $this->form->addOption();
    }

    public function removeOption($index){
        $this->form->removeOption($index);
    }

    public function generatePassword(){
        $this->form->generatePassword();
    }

}
