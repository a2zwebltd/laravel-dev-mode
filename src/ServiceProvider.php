<?php

namespace A2ZWeb\DevMode;

use A2ZWeb\DevMode\Console\Commands\Disable;
use A2ZWeb\DevMode\Console\Commands\Enable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/dev-mode.php', 'dev-mode');
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/dev-mode.php' => config_path('dev-mode.php'),
        ]);

        $this->setupCommands();
        $this->setupGateInterception();
    }

    private function setupCommands(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            Enable::class,
            Disable::class,
        ]);
    }

    private function setupGateInterception(): void
    {
        Gate::before(function (Authenticatable $user): ?bool {
            $ip = Request::ip();

            if ($ip && app(DevModeService::class)->isEnabled($user, $ip)) {
                return true;
            }

            return null;
        });
    }
}
