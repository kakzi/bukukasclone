<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryStock extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'toko_store_id',
        'product_id',
        'type',
        'quantity',
        'stock_progress',
        'catatan',
        'date'
    ];
}
