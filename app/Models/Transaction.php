<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'customer_id',
        'toko_store_id',
        'category_cash_out_id',//
        'type_transaction',
        'type_pay',
        'methode_catatan',
        'nominal_penjualan',
        'nominal_hpp',//
        'keuntungan',//
        'note',//
        'date',//
        'payment_id',//
        'channel_id',//
        'pelanggan_id',//
        'image',//
    ];

    public function getImageAttribute($image)
    {
        return asset('storage/transactions/'.$image);
    }
}
