<?php

namespace App\Providers;

use App\Services\MailjetEmailHandler;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind('Mailjet', function () {
            return new MailjetEmailHandler(env('MAILJET_API_KEY'), env('MAILJET_SECRET_KEY'));
        });
    }
}
