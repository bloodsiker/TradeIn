<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuybackRequestActFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buyback_request_act_forms', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('request_id')->unsigned();
            $table->string('fio')->nullable();
            $table->string('address')->nullable();
            $table->string('type_document')->nullable();
            $table->string('serial_number')->nullable();
            $table->text('issued_by')->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('buyback_request_act_forms');
    }
}
