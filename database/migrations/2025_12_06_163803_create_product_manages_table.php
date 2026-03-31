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
        Schema::create('product_manages', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->string('slug')->unique();
            $table->string('generic_id')->nullable();
            $table->integer('brand_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->decimal('buying_price', 10, 2)->default(0);
            $table->decimal('selling_price', 10, 2)->default(0)->index();
            $table->decimal('discounted_price', 10, 2)->nullable();
            $table->decimal('discount_percent', 5, 2)->nullable();
            $table->integer('stock')->default(0);
            $table->integer('flash_type'); // 1 = active, 0 = inactive
            $table->integer('status')->default(1); // 1 = active, 0 = inactive
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
        Schema::dropIfExists('product_manages');
    }
};
