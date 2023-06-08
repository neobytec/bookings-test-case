<?php

declare(strict_types=1);

namespace App\Infrastructure\Factories;

use ArrayObject;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\NotSupported;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

use function array_key_exists;
use function is_array;

class RepositoryFactory implements FactoryInterface
{
    /**
     * @param string $requestedName
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): object
    {
        if (! $container->has('config')) {
            throw new ServiceNotCreatedException('Cannot find a config array in the container');
        }

        try {
            $config = $container->get('config');
        } catch (NotFoundExceptionInterface | ContainerExceptionInterface) {
            throw new ServiceNotCreatedException('Config cannot be retrieved');
        }

        if (! (is_array($config) || $config instanceof ArrayObject)) {
            throw new ServiceNotCreatedException('Config must be an array or an instance of ArrayObject');
        }
        if (! isset($config[self::class])) {
            throw new ServiceNotCreatedException('Cannot find a `' . self::class . '` key in the config array');
        }

        $dependencies = $config[self::class];

        if (
            ! is_array($dependencies)
            || ! array_key_exists($requestedName, $dependencies)
        ) {
            throw new ServiceNotCreatedException('Service dependencies config must exist and be an array');
        }

        /** @var class-string $entiyClass */
        $entiyClass = $dependencies[$requestedName];

        try {
            /** @var EntityManager $entityManager */
            $entityManager = $container->get(EntityManager::class);
        } catch (NotFoundExceptionInterface | ContainerExceptionInterface) {
            throw new ServiceNotCreatedException('Cannot get EntityManager');
        }

        try {
            return $entityManager->getRepository($entiyClass);
        } catch (NotSupported) {
            throw new ServiceNotCreatedException('Repository cannot be created');
        }
    }
}
