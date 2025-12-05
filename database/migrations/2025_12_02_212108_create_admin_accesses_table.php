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
        Schema::create('admin_accesses', function (Blueprint $table) {
            $table->id();
            $table->integer('admin_id')->nullable();
            $table->tinyInteger('control_panel')->default(2);
            $table->tinyInteger('order_manage')->default(1);
            $table->tinyInteger('category')->default(1);
            $table->tinyInteger('brand')->default(1);
            $table->tinyInteger('product_manage')->default(1);
            $table->tinyInteger('shipment_manage')->default(1);
            $table->tinyInteger('shipping')->default(1);
            $table->tinyInteger('payment_methods')->default(1);
            $table->tinyInteger('sales_report')->default(2);
            $table->tinyInteger('settings')->default(1);
            $table->tinyInteger('pages_manage')->default(1);
            $table->tinyInteger('user_manage')->default(1);
            $table->tinyInteger('review_manage')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_accesses');
    }
};
