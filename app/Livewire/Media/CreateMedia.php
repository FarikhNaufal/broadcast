<?php

namespace App\Livewire\Media;

use App\Livewire\Media\Index as MediaIndex;
use App\Livewire\Forms\MediaForm;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateMedia extends Component
{
    use WithFileUploads;

    public MediaForm $form;

    public function mount(){
    }

    public function render()
    {
        return view('livewire.media.create-media');
    }

    public function storeMedia(){
        $this->form->store();
        $this->dispatch('media-changed');
        $this->dispatch('show-toast', msg: 'Media informasi baru berhasil ditambahkan...!');
        $this->dispatch('close-create-media-modal');
        $this->resetForm();
    }
    public function updateType(){
        $this->resetValidation('form.data');
        $this->form->data = null;
    }


    #[On('closeMediaModal')]
    public function closeModal(){
        $this->resetForm();
    }

    public function removeImage(){
        $this->reset('form.data');
    }

    public function resetForm(){
        $this->reset(['form.name', 'form.type', 'form.data']);

        $this->resetValidation();
    }
}
