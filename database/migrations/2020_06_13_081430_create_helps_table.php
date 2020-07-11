<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHelpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('helps', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('short_description')->nullable();
            $table->boolean('is_active');
            $table->timestamps();
        });

        Schema::create('help_files', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('help_id')->unsigned();
            $table->tinyInteger('type_file');
            $table->string('file');
            $table->timestamps();

            $table->foreign('help_id')->references('id')->on('helps')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('help_files');
        Schema::dropIfExists('helps');
    }
}
