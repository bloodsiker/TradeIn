<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevicePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device_prices', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('model_id')->unsigned();
            $table->float('price', 8, 2);
            $table->float('price_2', 8, 2);
            $table->float('price_3', 8, 2);
            $table->float('price_4', 8, 2);
            $table->float('price_5', 8, 2);
            $table->timestamps();

            $table->foreign('model_id')->references('id')->on('models')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('device_prices');
    }
}
