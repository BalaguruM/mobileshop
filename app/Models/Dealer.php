<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dealer extends Model
{
    protected $fillable = ['name', 'phone', 'address', 'gst_number', 'total_due', 'is_active'];

    protected $casts = ['total_due' => 'decimal:2', 'is_active' => 'boolean'];

    public function stockItems(): HasMany
    {
        return $this->hasMany(StockItem::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(DealerTransaction::class);
    }
}
