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
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class CacheResponse
{
    public function handle(Request $request, Closure $next)
    {
        $key = $this->generateCacheKey($request);

        if (Cache::has($key)) {
            $cachedData = Cache::get($key);
            return $this->buildResponseFromCache($cachedData);
        }

        $response = $next($request);

        if ($this->shouldCache($response)) {
            $this->cacheResponse($key, $response);
        }

        return $response;
    }

    protected function generateCacheKey(Request $request): string
    {
        return 'response_' . md5(
                $request->fullUrl() .
                json_encode($request->except(['_token', '_method']))
            );
    }

    protected function shouldCache($response): bool
    {
        return $response instanceof Response && $response->isSuccessful() && !$response->isRedirection();
    }

    protected function cacheResponse(string $key, Response $response): void
    {
        $cachedResponse = [
            'content' => $response->getContent(),
            'status' => $response->getStatusCode(),
            'headers' => $response->headers->all(),
        ];

        Cache::put($key, $cachedResponse, 60 * 60);
    }

    protected function buildResponseFromCache(array $cachedData): Response
    {
        $response = new Response($cachedData['content'], $cachedData['status']);
        foreach ($cachedData['headers'] as $key => $values) {
            $response->headers->set($key, $values);
        }
        return $response;
    }
}
