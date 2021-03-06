<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeviceModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device_models', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('brand_id')->unsigned();
            $table->bigInteger('network_id')->unsigned()->nullable();
            $table->string('name');
            $table->float('price', 8, 2)->default(0);
            $table->float('price_1', 8, 2)->default(0);
            $table->float('price_2', 8, 2)->default(0);
            $table->float('price_3', 8, 2)->default(0);
            $table->float('price_4', 8, 2)->default(0);
            $table->float('price_5', 8, 2)->default(0);
            $table->boolean('is_deleted')->default(0);
            $table->timestamps();

            $table->foreign('network_id')->references('id')->on('networks')->onDelete('set null');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('device_models');
    }
}
