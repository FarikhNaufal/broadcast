<?php

namespace App\Livewire\Media;

use App\Models\Media;
use Livewire\Attributes\On;
use Livewire\Component;

class ShowMedia extends Component
{
    public $showMediaModal = false;
    public ?Media $media = null;

    #[On('show-media-modal')]
    public function setMedia($media){
        $this->showMediaModal = true;
        $media = Media::findOrFail($media);
        $this->media = $media;
        $this->dispatch('show-media-modalx');
    }

    function closeMediaModal(){
        $this->showMediaModal = false;
        $this->reset();
    }

    #[On('show-media-modalx')]
    public function render(Media $media)
    {
        return view('livewire.media.show-media',[
            'media' => $this->media
        ]);
    }
}
