<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DealerTransaction extends Model
{
    protected $fillable = [
        'dealer_id', 'type', 'total_amount', 'paid_amount', 'due_amount',
        'date', 'due_date', 'notes',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'paid_amount'  => 'decimal:2',
        'due_amount'   => 'decimal:2',
        'date'         => 'date',
        'due_date'     => 'date',
    ];

    public function dealer(): BelongsTo
    {
        return $this->belongsTo(Dealer::class);
    }

    public function stockItems(): HasMany
    {
        return $this->hasMany(StockItem::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'transaction_id')->where('type', 'dealer');
    }
}
