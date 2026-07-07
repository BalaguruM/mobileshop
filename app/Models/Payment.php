<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = ['type', 'transaction_id', 'amount', 'mode', 'date', 'notes'];

    protected $casts = [
        'amount' => 'decimal:2',
        'date'   => 'date',
    ];

    public function dealerTransaction(): BelongsTo
    {
        return $this->belongsTo(DealerTransaction::class, 'transaction_id');
    }

    public function saleTransaction(): BelongsTo
    {
        return $this->belongsTo(SaleTransaction::class, 'transaction_id');
    }
}
