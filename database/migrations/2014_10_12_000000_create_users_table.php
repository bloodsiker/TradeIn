<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('role_id')->unsigned();
            $table->bigInteger('network_id')->unsigned()->nullable();
            $table->bigInteger('shop_id')->unsigned()->nullable();
            $table->string('name');
            $table->string('surname');
            $table->string('patronymic')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->unique();
            $table->date('birthday')->nullable();
            $table->string('avatar')->nullable();;
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('is_active')->default(true);
            $table->rememberToken();
            $table->timestamp('last_online')->nullable();
            $table->timestamps();

            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('network_id')->references('id')->on('networks')->onDelete('set null');
            $table->foreign('shop_id')->references('id')->on('shops')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
