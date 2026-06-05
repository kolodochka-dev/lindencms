<?php

namespace LindenCMS\Core;

use Illuminate\Support\ServiceProvider;
use LindenCMS\Core\Services\Init;
use LindenCMS\Core\Contracts\InitContract;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\Facades\Response;
use Illuminate\Pagination\Paginator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\LogoutResponse;
use Laravel\Fortify\Contracts\LoginResponse;

class CmsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Cms
        $this->app->bind(ImageManager::class, fn($app) => new ImageManager(new Driver()));
        View::addNamespace('cms', resource_path('cms/views'));
        Vite::useManifestFilename('.vite/manifest.json');
        
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
        Response::macro(
            'htmxRedirect',
            fn($route, $code = 200) => response('', $code, [
                'HX-Redirect' => $route,
                // 'HX-Refresh' => 'true',
            ])
        );

        Response::macro(
            'htmxReplaceUrl',
            fn($route, $content = '', $code = 200) =>
            response($content, $code, [
                'HX-Replace-Url' => $route,
            ])
        );

        Paginator::defaultView('cms::pagination.pagination');
    }
}