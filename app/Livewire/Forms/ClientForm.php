<?php

namespace App\Livewire\Forms;

use App\Models\Client;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ClientForm extends Form
{
    public ?Client $client;

    public $name;
    public $password;
    public $options = [];

    #[Validate('required')]
    public $usingGroup;
    public $groupID;


    public function setClient($client){
        $this->client = $client;
        $this->name = $client->name;
        $this->password = Crypt::decrypt($client->password);
        $this->usingGroup = $client->usingGroup();

        if ($this->usingGroup) {
            $this->groupID = $client->group_id;
        } else {
            $this->options = $client->media->map(function($media) {
                return [
                    'media' => $media->id,
                    'duration' => $media->pivot->duration
                ];
            })->toArray();
        }
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

    public function generatePassword(){
        $this->password = Str::random(12);
    }

    public function update(){
        $this->conditionalValidate();
        $this->client->update([
            'name' => $this->name,
            'password' => Crypt::encrypt($this->password),
            'group_id' => $this->usingGroup ? $this->groupID : null,
        ]);

        if ($this->usingGroup) {
            $this->client->media()->detach();
        } else {
            $mediaData = [];
            foreach ($this->options as $item) {
                $mediaData[$item['media']] = ['duration' => $item['duration']];
            }
            $this->client->media()->sync($mediaData);
        }


        activityLog('Client', 'pulse', 'yellow-500', 'Ubah client '.$this->name . ' berhasil');
    }

    public function store(){
        $this->conditionalValidate();
        $this->conditionalValidate();
        $client = Client::create([
            'name' => $this->name,
            'password' => Crypt::encrypt($this->password),
            'isActive' => false,
            'group_id' => $this->usingGroup ? $this->groupID : null,
        ]);

        if (!$this->usingGroup) {
            foreach ($this->options as $item) {
                $client->media()->attach($item['media'], ['duration' => $item['duration']]);
            }
        }
        activityLog('Client', 'pulse', 'yellow-500', 'Berhasil menambahkan client: '.$this->name);
    }
    public function conditionalValidate()
    {
        if ($this->usingGroup) {
            $this->validate([
                'groupID' => 'required|exists:groups,id',
                'name' => 'required|min:4|max:20|unique:clients,name,'.($this->client->id??null),
                'password' => 'required|min:8',
                'usingGroup' => 'required',
            ], [
                'usingGroup.required' => 'Jenis media harus diisi.',
                'groupID.required' => 'Group wajib diisi.',
                'name.required' => 'Nama client wajib diisi.',
                'name.min' => 'Nama minimal 4 karakter.',
                'name.max' => 'Nama maksimal 20 karakter.',
                'name.unique' => 'Nama client sudah ada.',
                'password.required' => 'Password wajib diisi.',
                'password.min' => 'Password minimal 8 karakter',
                'groupID.exists' => 'Group ID tidak valid.',

            ]);
        } else {
            $this->validate([
                'name' => 'required|min:4|max:20|unique:clients,name,'.($this->client->id??null),
                'password' => 'required|min:8',
                'usingGroup' => 'required',
                'options' => 'required|min:1',
                'options.*.media' => 'required|exists:media,id',
                'options.*.duration' => 'required|integer|min:1'
            ], [
                'name.required' => 'Nama client wajib diisi.',
                'name.unique' => 'Nama client sudah ada.',
                'name.min' => 'Nama minimal 4 karakter.',
                'name.max' => 'Nama maksimal 20 karakter.',
                'password.required' => 'Password wajib diisi.',
                'password.min' => 'Password minimal 8 karakter',
                'usingGroup.required' => 'Jenis media harus diisi.',
                'options.required' => 'Media wajib diisi.',
                'options.min' => 'Harus ada setidaknya satu media.',
                'options.*.media.required' => 'Media wajib diisi.',
                'options.*.media.exists' => 'Media tidak valid.',
                'options.*.duration.required' => 'Durasi wajib diisi.',
                'options.*.duration.integer' => 'Durasi harus berupa angka.',
                'options.*.duration.min' => 'Durasi harus lebih dari 1 detik.'
            ]);
        }
    }

}
