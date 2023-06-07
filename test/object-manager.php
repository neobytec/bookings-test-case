<?php

declare(strict_types=1);

use Doctrine\ORM\EntityManager;

$container = require __DIR__ . '/../config/container.php';

return $container->get(EntityManager::class);
