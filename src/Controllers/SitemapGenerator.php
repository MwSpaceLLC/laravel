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
use Illuminate\Http\Request;
use Spatie\Sitemap\SitemapGenerator as Sitemap;
use Spatie\Crawler\Crawler;

class SitemapGenerator extends Controller
{

    private function writeSitemap(): void
    {
        Sitemap::create(config('app.url'))
            ->configureCrawler(fn(Crawler $crawler) => $crawler->ignoreRobots())
            ->getSitemap()->writeToFile(public_path('index-sitemap.xml'));
    }

    function index(Request $request)
    {

        if (request()->getHost() === '127.0.0.1') {
            return response()->json([
                'sitemap' => 'Impossibile generare la sitemap sul server ' . request()->getHost(),
            ]);
        }

        // re-generate sitemap
        if ($request->has('generate')) {
            $this->writeSitemap();
            return redirect()->route('mwspace.sitemap', ['locale' => app()->getLocale()]);
        }

        if (file_exists(public_path('index-sitemap.xml'))) {
            return response()->file(
                public_path('index-sitemap.xml')
            );
        }

        $this->writeSitemap();

        return response()->file(
            public_path('index-sitemap.xml')
        );

    }
}
