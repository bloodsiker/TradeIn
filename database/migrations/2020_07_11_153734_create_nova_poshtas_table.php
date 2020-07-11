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
            $table->string('ttn');
            $table->timestamps();
        });

        Schema::create('nova_poshta_counterparties', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->string('ref');
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('nova_poshta_counterparty_persons', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('counterparty_id')->unsigned();
            $table->string('ref');
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->timestamps();

            $table->foreign('counterparty_id')->references('id')->on('nova_poshta_counterparties')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nova_poshta_counterparty_persons');
        Schema::dropIfExists('nova_poshta_counterparties');
        Schema::dropIfExists('nova_poshtas');
    }
}
