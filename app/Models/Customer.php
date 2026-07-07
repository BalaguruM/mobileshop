<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $fillable = ['name', 'phone', 'address', 'id_proof', 'total_due', 'is_active'];

    protected $casts = ['total_due' => 'decimal:2', 'is_active' => 'boolean'];

    public function saleTransactions(): HasMany
    {
        return $this->hasMany(SaleTransaction::class);
    }
}
