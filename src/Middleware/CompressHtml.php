<?php namespace MwSpace\Laravel\Middleware;

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

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CompressHtml
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($this->shouldCompress($response)) {
            $this->compressResponse($response);
        }

        return $response;
    }

    private function shouldCompress($response): bool
    {
        if (!$response instanceof Response) {
            return false;
        }

        $contentType = $response->headers->get('Content-Type');
        return $contentType && str_contains($contentType, 'text/html');
    }

    private function compressResponse(Response $response): void
    {
        $content = $response->getContent();
        $compressedContent = $this->compressHtml($content);
        $response->setContent($compressedContent);
    }

    private function compressHtml(string $html): string
    {
        $search = [
            '/\>[^\S ]+/s',
            '/[^\S ]+\</s',
            '/(\s)+/s',
            '/<!--(.|\s)*?-->/'
        ];

        $replace = [
            '>',
            '<',
            '\\1',
            ''
        ];

        return preg_replace($search, $replace, $html);
    }
}
