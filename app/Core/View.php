<?php

declare(strict_types=1);

final class View
{
    public static function render(string $template, array $data = []): string
    {
        extract($data, EXTR_SKIP);
        ob_start();
        require APP_PATH . '/Views/' . $template . '.php';

        return (string) ob_get_clean();
    }

    public static function page(string $template, array $data = []): void
    {
        $content = self::render($template, $data);
        extract($data, EXTR_SKIP);
        require APP_PATH . '/Views/layout.php';
    }
}
