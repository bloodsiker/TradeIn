<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNovaPoshtasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nova_poshtas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('packet_id')->unsigned();
            $table->string('sender');
            $table->string('sender_phone')->nullable();
            $table->string('recipient');
            $table->string('recipient_phone')->nullable();
            $table->text('description');
            $table->string('ref');
            $table->string('ttn');
            $table->string('cost');
            $table->date('date_delivery');
            $table->timestamps();

            $table->foreign('packet_id')->references('id')->on('buyback_packets')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

//        Schema::table('users', function (Blueprint $table) {
//            $table->string('nova_poshta_key')->nullable();
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nova_poshtas');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('nova_poshta_key');
        });
    }
}
