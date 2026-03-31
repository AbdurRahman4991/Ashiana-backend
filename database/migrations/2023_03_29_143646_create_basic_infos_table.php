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
        Schema::create('basic_infos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('favIcon',100)->nullable();
            $table->string('logo',100);
            $table->string('contact',100);
            $table->string('email',100);
            $table->string('address',100);
            $table->string('fbLink')->nullable();
            $table->string('instraLink')->nullable();
            $table->string('youTubeLink')->nullable();
            $table->string('map_address')->nullable();
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
        Schema::dropIfExists('basic_infos');
    }
};
