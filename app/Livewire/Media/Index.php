<?php

namespace App\Livewire\Media;

use App\Models\Media;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $pagination = 5;
    public $orderBy = 'desc';
    public $search = '';

    #[Layout('app')]
    #[On('media-changed')]
    public function render()
    {
        return view('livewire.media.index', [
            'medias' => $this->getMedia(),
            'mediaIsEmpty' => $this->mediaIsEmpty(),
        ]);
    }

    public function getMedia(){
        return Media::where('name', 'like', '%' . $this->search . '%')->orderBy('created_at', $this->orderBy)->paginate($this->pagination);
    }

    public function getMediaTypesProperty(){
        return [
            'text' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'icon' => 'lni lni-popup'],
            'youtube' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'icon' => 'lni lni-youtube'],
            'image' => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'icon' => 'lni lni-image'],
        ];
    }

    public function mediaIsEmpty(){
        return Media::count() == 0;
    }


}
