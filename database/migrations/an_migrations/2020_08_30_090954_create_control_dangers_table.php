<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateControlDangersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('control_dangers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('control_id');
            $table->unsignedBigInteger('danger_id');
            $table->timestamps();

            $table->foreign('control_id')
               ->references('id')
               ->on('controls');

            $table->foreign('danger_id')
                ->references('id')
                ->on('dangers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('control_dangers');
    }
}
