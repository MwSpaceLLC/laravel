<?php

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

use Illuminate\Support\Facades\Route;
use MwSpace\Laravel\Controllers\DefaultController;
use MwSpace\Laravel\Controllers\HooksController;
use MwSpace\Laravel\Controllers\PostsController;
use MwSpace\Laravel\Controllers\SitemapGenerator;
use Spatie\Honeypot\ProtectAgainstSpam;

/*
|--------------------------------------------------------------------------
| Application hooks
|--------------------------------------------------------------------------
|
| This value is the Route of your application. This value is used when the
| framework needs to place the application's Route in a
| any other location as required by the application or its packages.
|
*/

Route::prefix(__locales_prefix())->middleware('web')->group(function () {

    // mwspace names routes
    Route::name('mwspace.')->group(function () {

        // magic hidden routes
        Route::get('/', [DefaultController::class, 'index'])->name('index');
        Route::get('/sitemap.xml', [SitemapGenerator::class, 'index'])->name('sitemap');
        Route::get(__('/contatti'), [DefaultController::class, 'contacts'])->name('contacts');

        // hooks routes
        Route::name('hooks.')->group(function () {

            // route for contact
            Route::post(__('/contact'), [HooksController::class, 'contact'])->middleware(ProtectAgainstSpam::class)->name('contact');

        });

        // route for posts
        Route::get(__('/news'), [PostsController::class, 'posts'])->name('posts');
        Route::get(__('/news/{slug}'), [PostsController::class, 'post'])->name('post');

    });

});
