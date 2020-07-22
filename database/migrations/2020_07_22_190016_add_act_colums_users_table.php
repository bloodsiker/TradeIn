<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddActColumsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('act_paragraph_1')->nullable();
            $table->text('act_paragraph_2')->nullable();
            $table->string('act_tov')->nullable();
            $table->string('act_shop')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('act_paragraph_1');
            $table->dropColumn('act_paragraph_2');
            $table->dropColumn('act_tov');
            $table->dropColumn('act_shop');
        });
    }
}
