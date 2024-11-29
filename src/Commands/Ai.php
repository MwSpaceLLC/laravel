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

final class Ai extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mwspace:ai
                          {action : L\'azione da eseguire (es: make, generate, analyze)}
                          {context : Il contesto su cui eseguire l\'azione (es: page, component, model)}
                          ';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Use MwSpace AI in fresh laravel application';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        if (app()->version() < '11.0.0') {
            $this->error('mwspace/laravel engine require Laravel >= 11.0.0');
            return null;
        }

        if (!file_exists(base_path('mwspace.lock'))) {
            $this->error('mwspace/laravel not installed | use mwspace:install for development');
            return null;
        }

        // get action params
        $action = $this->argument('action');

        // get context params
        $context = $this->argument('context');

        // Verifica quale azione eseguire
        match ($action) {
            'make' => $this->handleMake($context),
            default => $this->error("Azione '$action' non supportata")
        };

        return null;

    }

    private function handleMake(string $context)
    {
        match ($context) {
            'page' => $this->makePage(),
            default => $this->error("Contesto '$context' non supportato per l'azione 'make'")
        };
    }

    private function makePage(): void
    {
        // Richiedi template finché non è valido
        $template = $this->askForTemplate();

        // Richiedi prompt finché non è valido
        $prompt = $this->askForPrompt();

        // Richiedi vista finché non è valida
        $view = $this->askForView();

        $this->info('Elaborazione in corso...');
        $this->info("Template: $template");
        $this->info("Prompt: $prompt");
        $this->info("Vista: $view");

        try {
            $this->processPage($template, $prompt, $view);
            $this->info('Pagina generata con successo!');
        } catch (\Exception $e) {
            $this->error('Si è verificato un errore durante la generazione della pagina: ' . $e->getMessage());
        }
    }

    private function askForTemplate(): string
    {
        do {
            $template = $this->ask('🤖 GPT | Quale file template HTML vuoi utilizzare per la creazione ?');

            if (empty($template)) {
                $this->warn('🤖 GPT | Il file template HTML è obbligatorio. Riprova.');
                continue;
            }

            if (!is_dir($template)) {
                $this->warn('🤖 GPT | Il file template HTML non esiste. Riprova.');
                continue;
            }

            return $template;

        } while (true);
    }

    private function askForPrompt(): string
    {
        do {
            $prompt = $this->ask('🤖 GPT | Descrivi brevemente il prompt per la generazione della pagina');

            if (empty($prompt)) {
                $this->warn('🤖 GPT | Il prompt è obbligatorio. Riprova.');
                continue;
            }

            return $prompt;

        } while (true);
    }

    private function askForView(): string
    {
        do {
            $view = $this->ask('🤖 GPT | Inserisci il nome della vista Blade (es: pages | pages.home.index)');

            if (empty($view)) {
                $this->warn('🤖 GPT | Il nome della vista è obbligatorio. Riprova.');
                continue;
            }

            if (!preg_match('/^[a-zA-Z0-9_.]+$/', $view)) {
                $this->warn('🤖 GPT | Il nome della vista contiene caratteri non validi. Usa solo lettere, numeri, punti e underscore. Riprova.');
                continue;
            }

            return $view;

        } while (true);
    }

    private function processPage(string $template, string $prompt, string $view): void
    {
        // TODO: Implementa qui la logica per:
        // 1. Leggere il template
        // 2. Utilizzare il prompt per generare il contenuto
        // 3. Creare la vista Blade

        // Per ora è solo un placeholder
        $this->info('🤖 GPT | Elaborazione della pagina...');
    }

}
