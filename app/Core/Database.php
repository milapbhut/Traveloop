<?php

declare(strict_types=1);

final class Database
{
    private static ?PDO $connection = null;
    private static bool $failed = false;

    public static function connection(): ?PDO
    {
        if (self::$connection instanceof PDO) {
            return self::$connection;
        }

        if (self::$failed) {
            return null;
        }

        $config = require BASE_PATH . '/config/database.php';
        $dsn = sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=%s',
            $config['host'],
            $config['port'],
            $config['database'],
            $config['charset']
        );

        try {
            self::$connection = new PDO($dsn, $config['username'], $config['password'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (Throwable) {
            self::$failed = true;
            return null;
        }

        return self::$connection;
    }
}
