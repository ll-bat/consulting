<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldIdToProcessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $firstField = \App\Field::first()->id;
        Schema::table('processes', function (Blueprint $table) use ($firstField) {
             $table->unsignedBigInteger('field_id')->after('id')->default($firstField);

             $table->foreign('field_id')
                 ->references('id')
                 ->on('fields');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('processes', function (Blueprint $table) {
            $table->dropColumn('field_id');
        });
    }
}
