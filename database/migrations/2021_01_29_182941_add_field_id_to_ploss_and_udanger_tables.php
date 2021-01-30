<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldIdToPlossAndUdangerTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $generalId = \App\Field::first()->id;

        Schema::table('plosses', function (Blueprint $table) use($generalId) {
            $table->unsignedBigInteger('field_id')->after('id')->default($generalId);

            $table->foreign('field_id')
                ->references('id')
                ->on('fields');
        });

        Schema::table('udangers', function (Blueprint $table) use($generalId) {
            $table->unsignedBigInteger('field_id')->after('id')->default($generalId);

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
        Schema::table('plosses', function (Blueprint $table) {
            $table->dropColumn('field_id');
        });

        Schema::table('udangers', function (Blueprint $table) {
            $table->dropColumn('field_id');
        });
    }
}
