<?php

namespace App\Livewire\Media;

use App\Events\NoDataEvent;
use App\Events\SendDataEvent;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;

class DeleteMedia extends Component
{

    public $deleteMediaModal = false;
    public $mediaName;
    public $mediaID;

    public function render()
    {
        return view('livewire.media.delete-media');
    }

    #[On('show-delete-media-modal')]
    public function showModal($id, $name){
        $this->mediaName = $name;
        $this->mediaID = $id;
        $this->deleteMediaModal = true;
    }

    public function delete(){
        $media = Media::findOrFail($this->mediaID);
        $clients = $media->client;
        foreach ($clients as $client) {
            NoDataEvent::dispatch($client);
        }

        $this->deleteMediaModal = false;
        if ($media->type == 'image') {
            Storage::delete($media->data);
        }
        if ($media->delete()) {
            $this->dispatch('media-changed');
            $this->dispatch('show-toast', msg: 'Media informasi berhasil dihapus...!');
        }

        activityLog('Media Informasi', 'printer', 'blue-500', 'Berhasil menghapus media: '.$this->mediaName);

    }
}
