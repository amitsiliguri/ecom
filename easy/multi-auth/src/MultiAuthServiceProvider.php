<?php

namespace Easy\MultiAuth;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\ServiceProvider;
use App\Http\Middleware\Authenticate as CoreAuthenticate;
use App\Http\Middleware\RedirectIfAuthenticated as CoreRedirectIfAuthenticated;
use Easy\MultiAuth\Http\Middleware\Authenticate;
use Easy\MultiAuth\Http\Middleware\RedirectIfAuthenticated;
use Easy\MultiAuth\Console\Commands\InstallMultiAuth;
use Easy\MultiAuth\Console\Commands\CreateAdmin;
use Easy\MultiAuth\Http\Middleware\HandleInertiaRequests;
use Illuminate\Contracts\Http\Kernel;
use Easy\MultiAuth\Models\Admin;
use Easy\MultiAuth\View\Components\AppLayout;
use Easy\MultiAuth\View\Components\GuestLayout;
use Illuminate\Routing\Router;
use Easy\MultiAuth\Http\Middleware\EnsureAdminEmailIsVerified;

class MultiAuthServiceProvider extends ServiceProvider
{
    /**
     * The path to the "admin dashboard" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const ADMIN_HOME = '/admin/dashboard';

    /**
     * Register services.
     *
     * @return void
     */
    public function register():void
    {
        $this->mergeAuthConfig();
        $this->app->singleton(CoreAuthenticate::class, Authenticate::class);
        $this->app->singleton(CoreRedirectIfAuthenticated::class, RedirectIfAuthenticated::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     * @throws BindingResolutionException
     */
    public function boot():void
    {
        $this->loadRoutesFrom(__DIR__.'/routes/multi-auth.php');
        $this->loadViewsFrom(__DIR__.'/views', 'mutli-auth');
        $this->loadViewComponentsAs('mutli-auth', [
            AppLayout::class,
            GuestLayout::class,
        ]);
        $this->bootInertia();
        if ($this->app->runningInConsole()) {
            $this->commands([
                CreateAdmin::class,
                InstallMultiAuth::class
            ]);

            $this->publishes([
                __DIR__.'/../stubs/resources/js' => resource_path('js'),
                __DIR__.'/../stubs/resources/css' => resource_path('css'),
                __DIR__.'/../stubs/database/migrations' => database_path('migrations'),
            ], 'multi-auth');
        }
    }

    /**
     * @throws BindingResolutionException
     */
    protected function bootInertia(): void
    {
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('admin.verified', EnsureAdminEmailIsVerified::class);

        $kernel = $this->app->make(Kernel::class);
        $kernel->appendMiddlewareToGroup('web', HandleInertiaRequests::class);
        $kernel->appendToMiddlewarePriority(HandleInertiaRequests::class);
    }

    /**
     * @return void
     */
    protected function mergeAuthConfig(): void
    {
        config([
            'auth.guards.admin' => array_merge([
                'driver' => 'session',
                'provider' => 'admins',
            ], config('auth.guards.admin', [])),
            'auth.providers.admins' => array_merge([
                'driver' => 'eloquent',
                'model' => Admin::class,
            ], config('auth.providers.admins', [])),
            'auth.passwords.admins' => array_merge([
                'provider' => 'admins',
                'table' => 'password_resets',
                'expire' => 10,
                'throttle' => 10,
            ], config('auth.passwords.admins', [])),
        ]);
    }
}
