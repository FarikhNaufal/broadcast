<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Media extends Model
{
    use HasFactory;
    protected $guarded = ['id'];


    public function client(): BelongsToMany{
        return $this->belongsToMany(Client::class);
    }

    public function media(): BelongsToMany{
        return $this->belongsToMany(Media::class);
    }
}
