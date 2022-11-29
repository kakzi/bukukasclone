<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryBussiness extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image'
    ];

    public function bussiness()
    {
        return $this->hasMany(TokoStore::class);
    }

    public function getImageAttribute($image)
    {
        return asset('storage/categories_bussiness/'.$image);
    }

}
