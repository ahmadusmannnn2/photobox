<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionPhoto extends Model
{
    protected $fillable = [
        'transaction_id',
        'image_path'
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
