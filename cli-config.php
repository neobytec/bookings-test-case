<?php

use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Laminas\ServiceManager\ServiceManager;
use Symfony\Component\Console\Helper\HelperSet;

$container = require 'config/container.php';

/** @var \Doctrine\ORM\EntityManager $entityManager */
$entityManager = $container->get(\Doctrine\ORM\EntityManager::class);

$helpers = ['em' => new EntityManagerHelper($entityManager)];

if (class_exists(DBALConsole\Helper\ConnectionHelper::class)) {
    $helpers['db'] = new DBALConsole\Helper\ConnectionHelper($entityManager->getConnection());
}

return new HelperSet($helpers);