<?php

namespace App\Livewire\ClientController;

use App\Events\SendDataEvent;
use App\Livewire\Forms\ClientForm;
use App\Models\Client;
use App\Models\Group;
use App\Models\Media;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class EditClient extends Component
{
    public ClientForm $form;
    public $editClientModal = false;
    public $medias;
    public $groups;

    #[Validate('required')]
    public $options = [];

    public function mount(){
        $this->medias = Media::all();
        $this->groups = Group::latest()->get();
        $this->form->addOption();
    }


    #[On('show-edit-client-modal')]
    public function setClient(Client $id){
        $this->editClientModal = true;
        $this->form->setClient($id);
    }

    public function generatePassword(){
        $this->form->generatePassword();
    }


    public function updateClient(){

        $this->form->update($this->options);
        $this->editClientModal = false;
        $this->dispatch('client-changed');
        $this->dispatch('show-toast', msg: 'Berhasil memperbarui client...!');
        $client = $this->form->client;
        SendDataEvent::dispatch($client);
    }

    public function addOption(){
        $this->form->addOption();
    }

    public function removeOption($index){
        $this->form->removeOption($index);
    }

    public function closeModal(){
        $this->editClientModal = false;
        $this->reset(['form.name', 'form.password', 'form.options', 'form.usingGroup', 'form.groupID']);
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.client-controller.edit-client');
    }
}
