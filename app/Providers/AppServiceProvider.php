<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\library\service;
use Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      view()->composer('shared.header', function($view){

        if(Auth::check()) {
          $messageTotal = Service::loadModel('UserInChatRoom')->where([
            ['user_id','=',Auth::user()->id],
            ['notify','=',1]
          ])->count();

          view()->share('_message_total',$messageTotal);
        }

      });

      view()->composer('shared.message-notification', function($view){

      });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
