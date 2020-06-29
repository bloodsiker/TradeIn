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
            $table->string('ref');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nova_poshta_counterparties');
        Schema::dropIfExists('nova_poshtas');
    }
}
