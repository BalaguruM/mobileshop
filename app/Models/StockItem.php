<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class StockItem extends Model
{
    protected $fillable = [
        'imei1', 'imei2', 'brand', 'model', 'variant', 'color',
        'dealer_id', 'dealer_transaction_id',
        'cost_price', 'selling_price', 'status',
        'date_added', 'warranty_period', 'box_contents',
    ];

    protected $casts = [
        'cost_price'    => 'decimal:2',
        'selling_price' => 'decimal:2',
        'date_added'    => 'date',
    ];

    public function dealer(): BelongsTo
    {
        return $this->belongsTo(Dealer::class);
    }

    public function dealerTransaction(): BelongsTo
    {
        return $this->belongsTo(DealerTransaction::class);
    }

    public function saleItem(): HasOne
    {
        return $this->hasOne(SaleItem::class);
    }

    public function getSaleTransactionAttribute()
    {
        return $this->saleItem?->saleTransaction;
    }
}
