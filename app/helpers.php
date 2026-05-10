<?php

declare(strict_types=1);

function e(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function url(string $path = ''): string
{
    $base = defined('APP_BASE') ? APP_BASE : '';
    $path = '/' . ltrim($path, '/');

    return $base . ($path === '/' ? '' : $path);
}

function asset(string $path): string
{
    return url($path);
}

function redirect_to(string $path): never
{
    header('Location: ' . url($path));
    exit;
}

function flash(string $key, ?string $message = null): ?string
{
    if ($message !== null) {
        $_SESSION['flash'][$key] = $message;
        return null;
    }

    $value = $_SESSION['flash'][$key] ?? null;
    unset($_SESSION['flash'][$key]);

    return $value;
}

function money(float|int|string|null $amount): string
{
    return '$' . number_format((float) $amount, 0);
}

function pretty_date(?string $date): string
{
    if (!$date) {
        return 'Flexible';
    }

    return date('M j, Y', strtotime($date));
}

function date_range(?string $start, ?string $end): string
{
    return pretty_date($start) . ' - ' . pretty_date($end);
}

function active_class(string $needle, string $page): string
{
    return $needle === $page ? 'is-active' : '';
}
