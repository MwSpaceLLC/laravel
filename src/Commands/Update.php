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
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use function Laravel\Prompts\spin;

class Update extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mwspace:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update mwspace/laravel in production project';

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
     * @return void
     */
    public function handle()
    {
        /**
         *
         */
        if (app()->version() < '11.0.0') {
            $this->error('mwspace/laravel engine require Laravel >= 11.0.0');
            return;
        }

        /**
         *
         */
        if (!file_exists(base_path('mwspace.lock'))) {
            $this->error('mwspace/laravel not installed | use mwspace:install for development');
            return;
        }

        /**
         * remove global errors from git
         */
        spin(fn() => shell_exec('git config --global pull.rebase false'),
            'git config...'
        );

        /**
         * Verifica l'esistenza della directory .git
         */
        if (is_dir(base_path('.git'))) {
            spin(fn() => shell_exec('git pull'),
                'git pull...'
            );
        }

        /**
         *
         */
        spin(fn() => shell_exec('composer install --optimize-autoloader --no-dev > /dev/null 2>&1 &'),
            'composer install...'
        );

        /**
         *
         */
        spin(fn() => shell_exec('php artisan storage:link'),
            'storage link...'
        );

        /**
         *
         */
        spin(fn() => shell_exec('php artisan optimize:clear'),
            'optimize clear...'
        );

        /**
         *
         */
        spin(fn() => shell_exec('php artisan optimize'),
            'optimize...'
        );

        /**
         *
         */
        $this->info('mwspace:update successful');

    }
}
