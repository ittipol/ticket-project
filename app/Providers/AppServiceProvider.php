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
      view()->composer('shared.message-notification', function($view){

        if(Auth::check()) {

          $messageUnreads = Service::loadModel('UserInChatRoom')->where([
            ['user_id','=',Auth::user()->id],
            ['notify','=',1]
          ])
          ->orderBy('message_read_date','desc')
          ->take(15)
          ->get();

          $_messageNotifications = array();
          foreach ($messageUnreads as $value) {
            $_messageNotifications[] = $value->getAttributes();
          }

          view()->share('_messageNotifications',$_messageNotifications);
        }

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
