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
        Schema::create('sub_sub_menus', function (Blueprint $table) {
            $table->id();
            $table->integer('menuID');
            $table->integer('subMenuID');
            $table->string('sub_subMenuName');
            $table->string('sub_submenu_slug');
            $table->string('meta_title');
            $table->string('title')->nullable();
            $table->longText('shortDetails')->nullable();
            $table->longText('longDetails')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('image')->nullable();
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
        Schema::dropIfExists('sub_sub_menus');
    }
};
