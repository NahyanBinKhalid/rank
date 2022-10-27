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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->references('id')->on('tasks');
            $table->string('type', 20);
            $table->integer('rank_group');
            $table->integer('rank_absolute');
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->string('domain');
            $table->string('url');
            $table->string('breadcrumb');
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
        Schema::dropIfExists('items');
    }
};
