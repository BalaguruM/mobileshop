<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_items', function (Blueprint $table) {
            $table->id();
            $table->string('imei1');
            $table->string('imei2')->nullable();
            $table->string('brand');
            $table->string('model');
            $table->string('variant')->nullable();
            $table->string('color')->nullable();
            $table->foreignId('dealer_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('dealer_transaction_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('cost_price', 12, 2)->default(0);
            $table->decimal('selling_price', 12, 2)->default(0);
            $table->enum('status', ['in_stock', 'sold', 'returned', 'damaged'])->default('in_stock');
            $table->date('date_added');
            $table->string('warranty_period')->nullable();
            $table->text('box_contents')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_items');
    }
};
