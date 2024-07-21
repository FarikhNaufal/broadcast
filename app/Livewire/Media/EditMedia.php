<?php

namespace App\Livewire\Media;

use App\Events\SendDataEvent;
use App\Livewire\Forms\MediaForm;
use App\Models\Media;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditMedia extends Component
{
    use WithFileUploads;
    public $editMediaModal = false;
    public MediaForm $form;

    // public $imagepath;

    #[On('show-edit-media-modal')]
    public function showModal(Media $id){
        $this->editMediaModal = true;
        $this->setMedia($id);

    }

    public function setMedia(Media $media){
        $this->form->setMedia($media);
    }

    public function updateMedia(){
        $this->form->update();
        $this->dispatch('show-toast', msg: 'Media informasi berhasil di ubah...!');
        $this->dispatch('media-changed');
        $this->editMediaModal = false;
        $clients = $this->form->media->client;
        foreach ($clients as $client) {
            SendDataEvent::dispatch($client);
        }

    }

    public function removeImage(){
        $this->reset('form.data');
    }

    public function render()
    {
        return view('livewire.media.edit-media');
    }
}
