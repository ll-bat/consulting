<?php

use App\UserText;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExportIdToUserTextsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        UserText::truncate();

        Schema::table('user_texts', function (Blueprint $table) {
            $table->unsignedBigInteger('export_id')->after('danger_id');

            $table->foreign('export_id')
                ->references('id')
                ->on('exports')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_texts', function (Blueprint $table) {
            $table->dropColumn('export_id');
        });
    }
}
