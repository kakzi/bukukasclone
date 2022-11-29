<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TokoStore extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'category_id',
        'customer_id', 
        'name', 
        'phone',
        'address',
        'type',
        'is_seller',
        'tujuan',
        'image',
    ];

    public function category()
    {
        return $this->belongsTo(CategoryBussiness::class);
    }

    public function getImageAttribute($image)
    {
        return asset('storage/store/'.$image);
    }
}
