<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTechnicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('technics', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->timestamps();
        });

        Schema::table('device_models', function (Blueprint $table) {
            $table->bigInteger('technic_id')->unsigned()->nullable();
            $table->foreign('technic_id')->references('id')->on('technics')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('technics');
        Schema::table('device_models', function (Blueprint $table) {
            $table->dropForeign(['technic_id']);
            $table->dropColumn('technic_id');
        });
    }
}
