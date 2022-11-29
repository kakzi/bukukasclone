<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'toko_store_id',
        'name',
        'code',
        'harga_jual',
        'is_hpp',
        'hpp',
        'is_notif_stock',
        'stock',
        'stock_minimum',
        'date'
    ];

}
