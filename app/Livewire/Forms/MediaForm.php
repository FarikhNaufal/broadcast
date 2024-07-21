<?php

namespace App\Livewire\Forms;

use App\Models\Media;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Form;

class MediaForm extends Form
{
    public ?Media $media;

    #[Validate('required|min:4|max:20',
    message: [
        'required' => 'Nama media wajib diisi.',
        'min' => 'Nama media minimal 4 karakter',
        'max' => 'Nama media maksimal 20 karakter',
    ]
    )]
    public $name;

    #[Validate('required', message:'Tipe media wajib dipilih.')]
    public $type;


    #[Validate('required', message:'Data media wajib diisi.')]
    public $data;


    public function setMedia(Media $media){
        $this->media = $media;
        $this->name = $media->name;
        $this->type = $media->type;
        $this->data = $media->data;
    }

    
    public function update(){
        $this->validate();
        if ($this->type == 'image' && $this->data != $this->media->data) {
            Storage::delete($this->media->data);
            $this->storeImage();
        } elseif ($this->type != 'image' && $this->media->type == 'image') {
            Storage::delete($this->media->data);
        }

        $this->media->update($this->except('media'));

        activityLog('Media Informasi', 'printer', 'blue-500', 'Berhasil merubah media: '.$this->name);
    }


    public function store(){
        $this->validate();
        if ($this->type == 'image') {
            $this->storeImage();
        }
        Media::create($this->except('media'));
        activityLog('Media Informasi', 'printer', 'blue-500', 'Berhasil menambahkan media: '.$this->name);
    }

    public function storeImage(){
        $imageName = time() . '-' . $this->data->getClientOriginalName();
        $path = $this->data->storeAs('public/media', $imageName);
        $this->data = $path;
    }


}
