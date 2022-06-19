<?php

namespace App\Providers;

use App\Models\Comment;
use App\Models\Contact;
use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    private $settings = [];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        foreach (glob(app_path()."/Infrastructure/*.php") as $path)
        {
            require_once $path;
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);//Length strings in all Pages = 191.

        view()->composer("*",function($view){

            if(empty($this->settings))
            {
                $this->settings = [
                    "Title" => "Default Title",
                    "Description" => "Default Description"
                ];//Setting:all();

                view()->share("settings",$this->settings);
            }

            if(empty(\Head::GetTitle()))
            {
                \Head::SetTitle($this->settings["Title"]);
            }
        });

        view()->composer('panel.*',function ($view){
            $countContacts = Contact::GetContact(['Status'=>'UnRead'])->count();
            $countComments = Comment::GetComment(['Status'=>'UnRead'])->count();
            view()->share('countContacts',$countContacts);
            view()->share('countComments',$countComments);

        });
    }
}
