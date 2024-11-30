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

class DefaultController extends Controller
{

    public function index()
    {

        if (!file_exists(resource_path("views/index.blade.php"))) {
            return view("mwspace::index");
        }

        return view("index");

    }

    public function contacts()
    {
        abort_if(!file_exists(resource_path("views/contacts.blade.php")), 404);

        return view("contacts");

    }

    public function about()
    {
        abort_if(!file_exists(resource_path("views/about.blade.php")), 404);

        return view("about");

    }

}
