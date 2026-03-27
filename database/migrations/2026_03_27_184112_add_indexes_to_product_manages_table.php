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
        Schema::table('product_manages', function (Blueprint $table) {
             // single column indexes
            $table->index('name');
            $table->index('brand_id');
            $table->index('category_id');

            // optional composite index for filtering
            $table->index(['category_id', 'brand_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_manages', function (Blueprint $table) {
            
            $table->dropIndex(['name']);
            $table->dropIndex(['brand_id']);
            $table->dropIndex(['category_id']);
            $table->dropIndex(['category_id', 'brand_id']);
        });
    }
};
