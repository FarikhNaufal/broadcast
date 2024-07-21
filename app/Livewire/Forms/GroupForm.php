<?php

namespace App\Livewire\Forms;

use App\Events\SendDataEvent;
use App\Models\Group;
use Livewire\Attributes\Validate;
use Livewire\Form;

class GroupForm extends Form
{
    public ?Group $group;

    #[Validate('required', message:'Nama group wajib diisi.')]
    public $name;

    #[Validate([
        'options' => 'required|min:1',
        'options.*.media' => 'required|exists:media,id',
        'options.*.duration' => 'required|integer|min:1'
    ], message: [
        'required' => ':attribute wajib diisi.',
        'min' => ':attribute harus lebih dari 1 detik.'
    ], attribute: [
        'options.*.media' => 'Media',
        'options.*.duration' => 'Durasi'
    ], as:'Media'
    )]
    public $options = [];


    public function setGroup($group){
        $this->group = $group;
        $this->name = $group->name;
        $this->options = $group->media->map(function($media) {
            return [
                'media' => $media->id,
                'duration' => $media->pivot->duration
            ];
        })->toArray();
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

    public function update(){
        $this->validate();
        $this->group->update([
            'name' => $this->name,
        ]);

        $mediaData = [];
        foreach ($this->options as $item) {
            $mediaData[$item['media']] = ['duration' => $item['duration']];
        }
        $this->group->media()->sync($mediaData);

        
    }

    public function store(){
        $this->validate();
        $group = Group::create($this->only('name'));
        foreach ($this->options as $item) {
            $group->media()->attach($item['media'], ['duration' => $item['duration']]);
        }
    }



}
