<?php

namespace LindenCMS\Cms;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;
use Illuminate\Pagination\Paginator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\LogoutResponse;
use Laravel\Fortify\Contracts\LoginResponse;
use LindenCMS\Cms\Console\Commands\InstallCommand;
use LindenCMS\Cms\Console\Commands\SyncCommand;

class CmsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Cms
        $this->app->bind(ImageManager::class, fn($app) => new ImageManager(new Driver()));

        // Fortify
        Fortify::loginView(fn() => view('cms::auth.login'));
        $this->app->instance(LogoutResponse::class, new class implements LogoutResponse {
            public function toResponse($request)
            {
                return redirect()->route('login');
            }
        });
        $this->app->instance(LoginResponse::class, new class implements LoginResponse {
            public function toResponse($request)
            {
                return redirect()->route('dashboard');
            }
        });
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/lindencms.php' => config_path('lindencms.php'),
        ]);
        
        $this->publishes([
            __DIR__ . '/../public/vendor/lindencms' => public_path('vendor/lindencms'),
        ], 'lindencms-assets');
        
        // Publish views (optional, for customization)
        // $this->publishes([
        //     __DIR__ . '/../resources/views' => resource_path('views/vendor/cms'),
        // ], 'lindencms-views');

        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'cms');

        Paginator::defaultView('cms::pagination.pagination');
        Response::macro('htmxRedirect', fn($route, $code = 200) => response('', $code, [
            'HX-Redirect' => $route,
        ]));
        Response::macro('htmxReplaceUrl', fn($route, $content = '', $code = 200) => response($content, $code, [
            'HX-Replace-Url' => $route,
        ]));

        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
                SyncCommand::class,
            ]);
        }
    }
}