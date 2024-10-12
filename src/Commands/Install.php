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

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mwspace:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install mwspace/laravel in fresh laravel installation';

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
        if (app()->version() < '11.0.0') {
            $this->error('mwspace/laravel engine require Laravel >= 11.0.0');
            return;
        }

        if (file_exists(base_path('mwspace.lock'))) {
            $this->error('mwspace/laravel already installed | use mwspace:update for production');
            return;
        }

        spin(fn() => shell_exec('php artisan vendor:publish --force --tag=mwspace.public'),
            'mwspace publish public...'
        );

        spin(fn() => shell_exec('php artisan vendor:publish --force --tag=mwspace.errors'),
            'mwspace publish errors...'
        );

        spin(fn() => shell_exec('php artisan lang:publish'),
            'lang publish...'
        );

        spin(fn() => shell_exec('php artisan storage:link'),
            'storage link...'
        );

        spin(fn() => shell_exec('php artisan optimize:clear'),
            'optimize clear...'
        );

        spin(fn() => $this->filesCopy(),
            'copy routes...'
        );

        spin(fn() => $this->manipulateEnv(),
            'edit .env file...'
        );

        spin(fn() => $this->end(),
            'complete installation...'
        );

        $this->info('mwspace:install successful');

    }

    private function end()
    {

        file_put_contents(base_path('mwspace.lock'), json_encode([
            'timestamp' => now()->toString(),
            'version' => composer()->version,
        ]));

    }

    private function manipulateEnv()
    {
        $envFile = base_path('.env');
        $envContents = file_get_contents($envFile);

        $envVariables = [
            'APP_NAME' => 'MwSpace',
            'APP_URL' => 'http://127.0.0.1:8000',
            'APP_TIMEZONE' => 'Europe/Rome',
            'APP_LOCALE' => 'it',
            'CACHE_STORE' => 'file',
            'SESSION_DRIVER' => 'database',
            'DB_CONNECTION' => 'sqlite',
            'MAIL_MAILER' => 'smtp',
            'MAIL_PORT' => '1025',
            'MAIL_CONTACT_INBOX' => 'hello@example.com',

            'MWSPACE_API_TOKEN' => '',
            'IUBENDA_POLICY_ID' => '',
            'IUBENDA_COOKIE_ID' => '',
            'LOG_SLACK_WEBHOOK_URL' => '',
            'GOOGLE_ANALYTICS_ID' => '',
            'GOOGLE_SITE_VERIFICATION' => '',
            'GOOGLE_RECAPTCHA_PUBLIC_KEY' => '',
            'GOOGLE_RECAPTCHA_SECRET_KEY' => '',
        ];

        foreach ($envVariables as $key => $value) {
            if (str_contains($envContents, $key . '=')) {
                $envContents = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $envContents);
            } else {
                $envContents .= "\n{$key}={$value}";
            }
        }

        file_put_contents($envFile, $envContents);
    }

    private function filesCopy()
    {
        // copia il file stub di routing
        File::copy(
            base_path('vendor/mwspace/laravel/src/stubs/routes/web.php'),
            base_path('routes/web.php')
        );

        // copia il file stub di bootstrap
        File::copy(
            base_path('vendor/mwspace/laravel/src/stubs/app.php'),
            base_path('bootstrap/app.php')
        );

        // Crea una directory se non esiste
        if (!File::exists(resource_path('views/components'))) {
            File::makeDirectory(resource_path('views/components'));
        }

        // copia il doc di default
        File::copy(
            base_path('vendor/mwspace/laravel/src/stubs/components/document.blade.php'),
            base_path('resources/views/components/document.blade.php')
        );

        // index non serve | show at DefaultController:index()[mwspace::index]
//        File::copy(
//            base_path('vendor/mwspace/laravel/src/stubs/views/index.blade.php'),
//            base_path('resources/views/index.blade.php')
//        );

        // delete default file
        File::delete(
            base_path('resources/views/welcome.blade.php')
        );
        File::delete(
            base_path('routes/console.php')
        );

    }
}
