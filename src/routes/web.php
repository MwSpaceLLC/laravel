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
use MwSpace\Laravel\Controllers\PostsController;

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

    Route::name('mwspace.')->group(function () {

        Route::prefix('hooks')->group(function () {
//            Route::post('/email', [HooksController::class, 'email'])->name('email');

//            Route::post('/contact', [HooksController::class, 'contact'])->name('contact');

//            Route::get((__('/confirm')), [HooksController::class, '_confirm'])->name('confirm.show');
//            Route::get(__('/confirm/{unique}'), [HooksController::class, 'confirm'])->name('confirm');
        });

        // route for products
//        Route::get(__('/products'), [HooksController::class, 'products'])->name('products');
//        Route::get(__('/products/{slug}'), [HooksController::class, 'product'])
//            ->where('slug', '.*')
//            ->name('product');

        // route for posts
        Route::get(__('/news'), [PostsController::class, 'posts'])->name('posts');
        Route::get(__('/news/{slug}'), [PostsController::class, 'post'])->name('post');

        // route for offers
//        Route::get(__('/offers'), [HooksController::class, 'offers'])->name('offers');
//        Route::get(__('/offers/{slug}'), [HooksController::class, 'offer'])
//            ->where('slug', '.*')
//            ->name('offer');

        // route for page || end of routes match
//        Route::get('/{slug}', [HooksController::class, 'page'])
//            ->where('slug', '.*')
//            ->name('page');

    });

});
