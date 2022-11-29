<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryCreditCashFlow extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'credit_cash_flow_id',
        'transaction_id',
        'toko_store_id',
        'nama_pelanggan',
        'type',
        'nominal',
        'nominal_progress',
        'catatan',
        'date',
        'image'
    ];

    public function getImageAttribute($image)
    {
        return asset('storage/history_credit_cash_flows/'.$image);
    }

}
