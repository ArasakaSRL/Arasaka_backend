<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Auth\UsuarioUserProvider;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
    //
  }

  /**
   * Bootstrap any application services.
   */
  public function boot(): void
  {
    ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
      return config("app.frontend_url") .
        "/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
    });

    Auth::provider('usuario_provider', function ($app, array $config) {
      return new UsuarioUserProvider($app['hash'], $config['model']);
    });
  }
}
