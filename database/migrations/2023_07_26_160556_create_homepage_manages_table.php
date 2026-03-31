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
        Schema::create('homepage_manages', function (Blueprint $table) {
            $table->id();
            $table->integer('menuId');
            $table->integer('subMenuId')->nullable();
            $table->string('subMenuName')->nullable();
            $table->integer('content_type')->nullable();
            $table->integer('submenu_slug')->nullable();
            $table->string('title');
            $table->longText('shortDetails')->nullable();
            $table->longText('longDetails')->nullable();
            $table->string('image')->nullable();
            $table->string('doumentfile')->nullable();
            $table->string('slug')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
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
        Schema::dropIfExists('homepage_manages');
    }
};
