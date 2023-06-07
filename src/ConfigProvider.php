<?php

declare(strict_types=1);

namespace App;

use Doctrine\ORM\EntityManager;
use Laminas\ServiceManager\AbstractFactory\ConfigAbstractFactory;
use Roave\PsrContainerDoctrine\EntityManagerFactory;

/**
 * The configuration provider for the App module
 *
 * @see https://docs.laminas.dev/laminas-component-installer/
 *
 * @psalm-suppress UnusedClass
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     */
    public function __invoke(): array
    {
        return [
            'dependencies'               => $this->getDependencies(),
            ConfigAbstractFactory::class => $this->getAbstractFactories(),
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies(): array
    {
        return [
            'invokables'         => [],
            'factories'          => [
                'migrations.entity_manager.orm_default' => EntityManagerFactory::class,
                EntityManager::class                    => EntityManagerFactory::class,
            ],
            'abstract_factories' => [
                ConfigAbstractFactory::class,
            ],
            'aliases'            => [],
        ];
    }

    private function getAbstractFactories(): array
    {
        return [];
    }
}
