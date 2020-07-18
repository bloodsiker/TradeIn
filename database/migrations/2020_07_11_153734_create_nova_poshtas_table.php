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
            $table->string('ref');
            $table->string('ttn');
            $table->string('cost');
            $table->date('date_delivery');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('nova_poshta_requests', function (Blueprint $table) {
            $table->bigInteger('np_id')->unsigned();
            $table->bigInteger('request_id')->unsigned();

            $table->foreign('np_id')->references('id')->on('nova_poshtas')->onDelete('cascade');
            $table->foreign('request_id')->references('id')->on('buyback_requests')->onDelete('cascade');
        });

        Schema::create('users', function (Blueprint $table) {
            $table->string('nova_poshta_key')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nova_poshta_requests');
        Schema::dropIfExists('nova_poshtas');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('nova_poshta_key');
        });
    }
}
