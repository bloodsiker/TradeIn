<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::create('chats', function (Blueprint $table) {
//            $table->id();
//            $table->tinyInteger('type_chat');
//            $table->string('name')->nullable();
//            $table->string('uniq_id', 100);
//        });
//
//        Schema::create('chat_user', function (Blueprint $table) {
//            $table->id();
//            $table->bigInteger('chat_id')->unsigned();
//            $table->bigInteger('user_id')->unsigned();
//
//            $table->foreign('chat_id')->references('id')->on('chats')->onDelete('cascade');
//            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
//        });
//
//        Schema::create('chat_messages', function (Blueprint $table) {
//            $table->id();
//            $table->bigInteger('chat_id')->unsigned();
//            $table->bigInteger('user_id')->unsigned();
//            $table->text('message');
//            $table->timestamps();
//
//            $table->foreign('chat_id')->references('id')->on('chats')->onDelete('cascade');
//            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
//        });

        Schema::create('chat_message_user', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('message_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('chat_id')->unsigned();

            $table->foreign('message_id')->references('id')->on('chat_messages')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('chat_id')->references('id')->on('chats')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chat_message_user');
        Schema::dropIfExists('chat_messages');
        Schema::dropIfExists('chat_user');
        Schema::dropIfExists('chats');
    }
}
