<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'toko_store_id',
        'name',
        'icon'
    ];

    public function getIconAttribute($icon)
    {
        return asset('storage/channels/'.$icon);
    }
}
