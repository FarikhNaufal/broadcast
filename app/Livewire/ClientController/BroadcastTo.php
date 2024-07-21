<?php

namespace App\Livewire\ClientController;

use App\Events\SendDataEvent;
use App\Models\Client;
use App\Models\Group;
use App\Models\Media;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class BroadcastTo extends Component
{

    public $clients = [];
    public $options = [];
    public $groupID;
    public $checked;
    public $usingGroup;


    public function mount(){
        $this->addOption();
    }

    #[On('client-changed')]
    public function render()
    {
        return view('livewire.client-controller.broadcast-to',[
            'clientsx' => Client::latest()->get(),
            'medias' => Media::latest()->get(),
            'groups' => Group::latest()->get(),
        ]);
    }

    public function addOption(){
        $this->options[] = [
            'media' => null,
            'duration' => null
        ];
    }

    public function removeOption($index){
        unset($this->options[$index]);
        $this->options = array_values($this->options);
    }

    #[On('broadcastModalClosed')]
    public function closeModal(){
        $this->resetForm();
        $this->dispatch('close-broadcast-to-modal');
    }

    public function resetForm(){
        $this->reset(['clients', 'groupID', 'usingGroup', 'options', 'checked']);
        $this->resetValidation();
    }

    public function broadcastTo()
    {
        foreach ($this->clients as $clientx) {
            $client = Client::findOrFail($clientx);
            if ($this->usingGroup) {
                if (!$client->usingGroup()) {
                    $client->media()->detach();
                }
                $client->update(['group_id' => $this->groupID]);
            } else {
                if ($client->usingGroup()) {
                    $client->update(['group_id' => null]);
                }
                $mediaData = [];
                foreach ($this->options as $item) {
                    $mediaData[$item['media']] = ['duration' => $item['duration']];
                }
                $client->media()->sync($mediaData);
            }

            if ($client->isActive) {
                SendDataEvent::dispatch($client);
            }
        }
        $this->dispatch('close-broadcast-to-modal');
        $this->dispatch('client-changed');
        $this->dispatch('show-toast', msg: 'Berhasil broadcast media ke client yang dipilih...!');
    }

}
