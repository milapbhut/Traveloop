<?php

declare(strict_types=1);

return [
    'host' => getenv('TRAVELOOP_DB_HOST') ?: '127.0.0.1',
    'port' => getenv('TRAVELOOP_DB_PORT') ?: '3306',
    'database' => getenv('TRAVELOOP_DB_NAME') ?: 'traveloop',
    'username' => getenv('TRAVELOOP_DB_USER') ?: 'root',
    'password' => getenv('TRAVELOOP_DB_PASS') ?: '',
    'charset' => 'utf8mb4',
];
