<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuybackPacketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buyback_packets', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->string('name');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('buyback_packet_request', function (Blueprint $table) {
            $table->bigInteger('packet_id')->unsigned();
            $table->bigInteger('request_id')->unsigned();

            $table->foreign('packet_id')->references('id')->on('buyback_packets')->onDelete('cascade');
            $table->foreign('request_id')->references('id')->on('buyback_requests')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buyback_packet_request');
        Schema::dropIfExists('buyback_packets');
    }
}
