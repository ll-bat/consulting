<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSomeFieldsToProfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->string('phone')->nullable(true)->default('');
            $table->boolean('organization')->default(false);
            $table->string('work_organization')->nullable(true)->default('');
            $table->string('work')->nullable(true)->default('');
            $table->string('position_in_organization')->nullable(true)->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn(['phone', 'organization', 'work_organization', 'work', 'position_in_organization']);
        });
    }
}
