<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Dotenv\Dotenv;
use Monolog\Logger;

return function (ContainerBuilder $containerBuilder): void {
    Dotenv::createImmutable(__DIR__ . ' /..')->load();

    // Global Settings Object
    $containerBuilder->addDefinitions([
        'settings' => [
            'displayErrorDetails' => getenv('APP_ENV') !== 'production', // Should be set to false in production
            'logger' => [
                'name' => getenv('APP_NAME') ?? 'Zhinahan',
                'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
                'level' => Logger::DEBUG,
            ],
            'db' => [
                'connection' => getenv('DB_CONNECTION'),
                'dbname'     => getenv('DB_DATABASE'),
                'user'       => getenv('DB_USERNAME'),
                'pass'       => getenv('DB_PASSWORD'),
            ],
        ],
    ]);
};
