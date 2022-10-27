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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('search_id')->references('id')->on('searches');
            $table->string('task_uuid', 255);
            $table->string('task_cost', 10)->nullable();
            $table->string('search_engine', 10)->nullable();
            $table->string('search_engine_type', 10)->nullable();
            $table->string('request_os', 20)->nullable();
            $table->integer('items_count')->nullable()->unsigned();
            $table->bigInteger('engine_results_count')->nullable()->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->index('items_count');
            $table->index('engine_results_count');
            $table->index('task_uuid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->dropIndex('items_count');
            $table->dropIndex('engine_results_count');
            $table->dropIndex('task_uuid');
        });

        Schema::dropIfExists('tasks');
    }
};
