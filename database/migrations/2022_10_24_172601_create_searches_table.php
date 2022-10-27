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
        Schema::create('searches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('engine_id')->references('id')->on('engines');
            $table->foreignId('language_id')->references('id')->on('languages');
            $table->foreignId('country_id')->references('id')->on('countries');
            $table->string('keyword', 255);
            $table->string('tag', 255);
            $table->integer('iterations');
            $table->enum('device_type', ['desktop', 'mobile']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('searches');
    }
};
