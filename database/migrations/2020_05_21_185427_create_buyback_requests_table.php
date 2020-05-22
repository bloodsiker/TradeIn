<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuybackRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buyback_requests', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('model_id')->unsigned();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('imei');
            $table->string('number_packet');
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
        Schema::dropIfExists('buyback_requests');
    }
}
