<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_delivery_items', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id');
            $table->integer('order_delivery_id');
            $table->integer('order_item_id');
            $table->integer('product_id');
            $table->decimal('selling_price', 10, 2);
            $table->decimal('discount_percent', 10, 2);
            $table->decimal('discounted_price', 10, 2);
            $table->string('status')->default('pending');
            $table->integer('qty');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_delivery_items');
    }
};
