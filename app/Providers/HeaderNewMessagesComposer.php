<?php

namespace App\Providers;

use App\Models\ChatMessageUser;
use Illuminate\Support\ServiceProvider;

class HeaderNewMessagesComposer extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('cabinet.blocks._header', function($view){
            $count = \DB::table('chat_message_user')->where('user_id', \Auth::id())->count();
            $view->with('count_message', $count);

            $messages = ChatMessageUser::query()
                ->with('message', 'user', 'chat')
                ->where('chat_message_user.user_id', \Auth::id())->orderBy('id', 'DESC')->paginate(5);

            $view->with('new_messages', $messages);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
