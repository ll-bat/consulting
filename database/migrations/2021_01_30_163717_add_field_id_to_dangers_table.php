<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldIdToDangersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $firstId = \App\Field::first()->id;

        Schema::table('dangers', function (Blueprint $table) use($firstId) {
            $table->unsignedBigInteger('field_id')->after('id')->default($firstId);

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
        Schema::table('dangers', function (Blueprint $table) {
            $table->dropColumn('field_id');
        });
    }
}
