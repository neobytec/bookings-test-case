<?php

declare(strict_types=1);

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

return [
    'doctrine' => [
        'connection'    => [
            'orm_default' => [
                'params' => [
                    'host'          => 'db',
                    'port'          => '3306',
                    'user'          => 'bookings',
                    'password'      => 'bookings',
                    'dbname'        => 'bookings',
                    'driverOptions' => [
                        1002 => 'SET NAMES utf8',
                    ],
                ],
            ],
        ],
        'driver'        => [
            'orm_default' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [
                    __DIR__ . '/../../src/Infrastructure/Data/Entity',
                ],
            ],
        ],
        'migrations'    => [
            'orm_default' => [
                'migrations_paths' => [
                    'App\Infrastructure\Data\Migration' => __DIR__ . '/../../src/Infrastructure/Data/Migration',
                ],
            ],
        ],
        'configuration' => [
            'orm_default' => [
                'query_cache'     => 'array',
                'result_cache'    => 'array',
                'metadata_cache'  => 'array',
                'hydration_cache' => 'array',
            ],
        ],
    ],
];
