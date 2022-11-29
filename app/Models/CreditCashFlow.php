<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditCashFlow extends Model
{
    use HasFactory;use HasFactory;
    
    protected $fillable = [
        'toko_store_id',
        'nama_pelanggan',
        'type',
        'nominal',
        'catatan',
        'date',
        'image'
    ];

    public function getImageAttribute($image)
    {
        return asset('storage/credit_cash_flows/'.$image);
    }
}
