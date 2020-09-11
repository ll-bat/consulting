<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDangerProcessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('danger_process', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('danger_id');
            $table->unsignedBigInteger('process_id');
            $table->timestamps();

            $table->foreign('danger_id')
               ->references('id')
               ->on('dangers');

            $table->foreign('process_id')
                ->references('id')
                ->on('processes');
                
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('danger_processes');
    }
}
