<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;


class Client extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $keyType = 'string';
    public $incrementing = false;
    protected $guarded = ['id'];
    protected $guard = 'client';

    public static function booted() {
        static::creating(function (Client $client) {
            $client->id = Str::uuid();
        });
    }

    public function media(): BelongsToMany{
        return $this->belongsToMany(Media::class)->withPivot('duration');
    }

    public function group(): BelongsTo{
        return $this->belongsTo(Group::class);
    }

    public function usingGroup(){
        return $this->group_id !== null;
    }

    
}
