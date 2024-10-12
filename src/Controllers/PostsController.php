<?php namespace MwSpace\Laravel\Controllers;

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

use App\Http\Controllers\Controller;
use Illuminate\Http\Client\ConnectionException;

class PostsController extends Controller
{
    /**
     * @throws ConnectionException
     */
    public function posts(...$parameters): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        // Setta il locale per la query
        $locale = app()->getLocale();

        $posts = mwspace()->get('/posts')->collect()->map(function ($post) {

            // add permalink to the post
            $post['href'] = _route('mwspace.post', $post['permalink']);

            return (object)$post;
        });

        if (!file_exists(resource_path("views/posts.blade.php"))) {
            return view("mwspace::posts", [
                'items' => $posts
            ]);
        }

        return view("posts", [
            'items' => $posts
        ]);

    }

    /**
     * @throws ConnectionException
     */
    public function post(...$parameters): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        // Setta il locale per la query
        $locale = app()->getLocale();

        $slug = end($parameters);

        $post = _array_to_object(mwspace()->get("/posts/$slug")->json());

        if (!file_exists(resource_path("views/post.blade.php"))) {
            return view("mwspace::post", [
                'item' => $post
            ]);
        }

        return view("post", [
            'item' => $post
        ]);

    }

}
