<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SaleTransaction extends Model
{
    protected $fillable = [
        'customer_id', 'customer_name_override',
        'total_amount', 'discount', 'paid_amount', 'due_amount',
        'payment_mode', 'date', 'due_date', 'notes',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'discount'     => 'decimal:2',
        'paid_amount'  => 'decimal:2',
        'due_amount'   => 'decimal:2',
        'date'         => 'date',
        'due_date'     => 'date',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function saleItems(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'transaction_id')->where('type', 'customer');
    }

    public function getCustomerLabelAttribute(): string
    {
        return $this->customer?->name ?? $this->customer_name_override ?? 'Walk-in';
    }
}
