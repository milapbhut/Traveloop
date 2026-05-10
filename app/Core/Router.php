<?php

declare(strict_types=1);

final class Router
{
    private array $routes = [];

    public function get(string $pattern, callable|array $handler): void
    {
        $this->add('GET', $pattern, $handler);
    }

    public function post(string $pattern, callable|array $handler): void
    {
        $this->add('POST', $pattern, $handler);
    }

    private function add(string $method, string $pattern, callable|array $handler): void
    {
        $this->routes[] = [
            'method' => $method,
            'pattern' => $pattern,
            'regex' => $this->compile($pattern),
            'handler' => $handler,
        ];
    }

    public function dispatch(string $method, string $uri): void
    {
        $path = parse_url($uri, PHP_URL_PATH) ?: '/';
        $base = defined('APP_BASE') ? APP_BASE : '';

        if ($base !== '' && str_starts_with($path, $base)) {
            $path = substr($path, strlen($base)) ?: '/';
        }

        $path = '/' . trim($path, '/');
        if ($path !== '/' && str_ends_with($path, '/')) {
            $path = rtrim($path, '/');
        }

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }

            if (preg_match($route['regex'], $path, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                call_user_func_array($route['handler'], $params);
                return;
            }
        }

        http_response_code(404);
        View::page('pages/not-found', [
            'title' => 'Page not found',
            'page' => 'not-found',
        ]);
    }

    private function compile(string $pattern): string
    {
        $regex = preg_replace('#\{([a-zA-Z_][a-zA-Z0-9_]*)\}#', '(?P<$1>[^/]+)', $pattern);

        return '#^' . $regex . '$#';
    }
}
