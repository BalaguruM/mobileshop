<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['dealer', 'customer']);
            $table->unsignedBigInteger('transaction_id');
            $table->decimal('amount', 12, 2);
            $table->enum('mode', ['cash', 'upi', 'card', 'bank_transfer', 'other'])->default('cash');
            $table->date('date');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
