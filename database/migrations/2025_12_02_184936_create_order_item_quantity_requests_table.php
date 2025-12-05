<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_item_quantity_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('order_item_id')->nullable();
            $table->integer('quantity_request_id')->nullable();
            $table->integer('qty_used'); // how many qty taken from this row
            $table->decimal('buy_price', 10, 2); // cost price per item at the time
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_item_quantity_requests');
    }
};
