<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetails extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'transaction_id',
        'toko_store_id',
        'product_id',
        'total_item',
        'total_harga',
        'catatan'
    ];

}
