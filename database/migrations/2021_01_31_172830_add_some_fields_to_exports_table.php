<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSomeFieldsToExportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exports', function (Blueprint $table) {
            $table->string("author-names", 400)->after('filename')->default('');
            $table->string("address", 600)->after('author-names')->default('');
            $table->string('description', 900)->after('address')->default('');
            $table->string('first_date', 50)->after('description')->default('');
            $table->string('second_date', 50)->after('first_date')->default('');
            $table->string('number', 50)->after('second_date')->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exports', function (Blueprint $table) {
            $table->dropColumn('author-names');
            $table->dropColumn('address');
            $table->dropColumn('description');
            $table->dropColumn('first_date');
            $table->dropColumn('second_date');
            $table->dropColumn('number');
        });
    }
}
