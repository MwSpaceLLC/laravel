<?php namespace MwSpace\Laravel;

/**
 * @copyright 2024 | MwSpace llc, srl
 * @package mwspace/laravel
 * @author Aleksandr Ivanovitch
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 *
 * @license http://www.apache.org/licenses/LICENSE-2.0
 *
 */

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\ServiceProvider as MineServiceProvider;

use MwSpace\Laravel\Commands\Ai;
use MwSpace\Laravel\Commands\Install;
use MwSpace\Laravel\Commands\Languages;
use MwSpace\Laravel\Commands\Update;
use MwSpace\Laravel\Middleware\CompressHtml;
use MwSpace\Laravel\Middleware\LangSwitcher;

/**
 * Main class of MwSpace provider
 */
class ServiceProvider extends MineServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function boot(): void
    {
        $this->checkRequirements();

        $this->registerHelpers();

        $this->registerMiddleware();

        $this->registerRoutes();

        $this->registerCommands();

        $this->registerMigrations();

        $this->registerPublishing();

        $this->registerLanguages();

        $this->registerViews();

        $this->registerViewShare();

        $this->registerComponents();

        // merge config at runtime
        $this->configRuntime();
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->registerConfig();

        $this->registerStorageDriver();
    }

    /**
     * Check configuration system
     */
    private function checkRequirements()
    {
        //
    }

    /**
     * Register the helpers routes.
     *
     */
    private function registerHelpers(): void
    {
        // 3.8 | admin no redirect to main locales
        if (!$this->app->runningInConsole()) {

            app()->setLocale(__locales_exists() ? request()->segment(1) : app()->getLocale());

        }
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    private function registerMiddleware(): void
    {

        if (!$this->app->runningInConsole()) {

            $this->prependMiddlewareToGroup('web', LangSwitcher::class);
            $this->appendMiddlewareToGroup('web', CompressHtml::class);
//            $this->appendMiddlewareToGroup('web', CacheResponse::class);

        }

    }

    /**
     * Register the package routes.
     *
     * @return void
     */
    private function registerRoutes(): void
    {

        // must not load in console.
        if (!$this->app->runningInConsole()) {
            $this->app->booted(function () {
                $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
            });
        }

    }

    /**
     * Register the Artisan Commands
     */
    private function registerCommands(): void
    {
        $this->commands([
            Ai::class,
            Install::class,
            Languages::class,
            Update::class,
        ]);
    }

    /**
     * Register the package's migrations.
     *
     * @return void
     */
    private function registerMigrations(): void
    {
        if ($this->app->runningInConsole()) {
            //
        }
    }

    /**
     * Register the view's package.
     *
     * @return void
     */
    private function registerViews(): void
    {
        $this->loadViewsFrom(
            __DIR__ . '/resources/views', 'mwspace'
        );
    }

    /**
     * Register the view's share vars.
     *
     * @return void
     */
    private function registerViewShare(): void
    {
        if (!$this->app->runningInConsole()) {
            $this->app->booted(function () {
                //
            });
        }
    }

    /**
     * Register the component's package.
     *
     * @return void
     */
    private function registerComponents()
    {
        //
    }

    /**
     * Register the package's migrations.
     *
     * @return void
     */
    private function registerLanguages()
    {
        //
    }

    /**
     * set at runtime for package (Important)
     * es. package php run with queue jobs
     */
    private function configRuntime()
    {
        //
    }

    /**
     * registerConfig function (Important)
     */
    private function registerConfig()
    {
        //
    }

    /**
     * Register the package storage driver.
     *
     * @return void
     */
    private function registerStorageDriver()
    {
        //
    }

    /**
     * Register the package's publishable resources.
     *
     * @return void
     */
    private function registerPublishing(): void
    {
        // publish assets
        $this->publishes(
            [__DIR__ . '/public' => public_path()], 'mwspace.public'
        );

        $this->publishes(
            [__DIR__ . '/resources/views/errors' => resource_path('views/errors')], 'mwspace.errors'
        );
    }

    protected function prependMiddlewareToGroup($group, $middleware): void
    {
        $kernel = $this->app[Kernel::class];

        foreach ((array)$middleware as $mw) {
            $kernel->prependMiddlewareToGroup($group, $mw);
        }
    }

    protected function appendMiddlewareToGroup($group, $middleware): void
    {
        $kernel = $this->app[Kernel::class];

        foreach ((array)$middleware as $mw) {
            $kernel->appendMiddlewareToGroup($group, $mw);
        }
    }

}
