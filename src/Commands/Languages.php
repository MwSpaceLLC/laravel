<?php namespace MwSpace\Laravel\Commands;

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

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use function Laravel\Prompts\spin;

class Languages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mwspace:lang {locale?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Search translation json and generate lang';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return void|null
     */
    public function handle()
    {
        if (app()->version() < '11.0.0') {
            $this->error('mwspace/laravel engine require Laravel >= 11.0.0');
            return;
        }

        if (!file_exists(base_path('mwspace.lock'))) {
            $this->error('mwspace/laravel not installed | use mwspace:install for development');
            return;
        }

        $locale = config('app.locale');

        /**
         * prompt already inform user
         */
        spin(fn() => $this->translate_json($locale),
            "search [$locale.json] entries..."
        );

        $this->info('mwspace:lang successful');

    }

    /**
     * @param $locale
     * @return void
     */
    private function translate_json($locale): void
    {
        $newEntries = [];

        $files = [
            ...File::allFiles(base_path('app')),
            ...File::allFiles(base_path('config')),
            ...File::allFiles(resource_path('views')),
            ...File::allFiles(base_path('routes')),
        ];

        foreach ($files as $file) {

            $content = File::get($file);
            preg_match_all('/__\(\'(.*?)\'\)/', $content, $matches);

            foreach ($matches[1] as $match) {

                $newEntries[$match] = $match;
            }
        }

        $langFile = base_path("lang/$locale.json");

        // Check if the file exists, if not, create it with an empty array
        if (!File::exists($langFile)) {
            File::put($langFile, json_encode([], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        }

        $langData = json_decode(File::get($langFile), true);

        // Merge new entries into existing lang data
        $updatedLangData = array_merge($langData, $newEntries);

        // Save the updated lang data back to lang.json
        File::put($langFile, json_encode($updatedLangData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }

}
