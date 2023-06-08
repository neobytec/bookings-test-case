<?php

declare(strict_types=1);

namespace App;

use App\Application\Actions\UseCases\ProcessActionUseCase;
use App\Application\Bookings\UseCases\ListCancelledBookingsUseCase;
use App\Application\Bookings\UseCases\ListInsuredBookingsUseCase;
use App\Domain\Actions\Services\ValidateActionService;
use App\Domain\Bookings\Services\CancelBookingsService;
use App\Domain\Bookings\Services\GetBookingService;
use App\Domain\Bookings\Services\ListCancelledBookingsService;
use App\Domain\Bookings\Services\ListInsuredBookingsService;
use App\Domain\Insurances\Services\CreateInsuranceService;
use App\Infrastructure\Data\Entity\Actions;
use App\Infrastructure\Data\Entity\Bookings;
use App\Infrastructure\Data\Entity\Insurances;
use App\Infrastructure\Data\Repository\ActionsRepository;
use App\Infrastructure\Data\Repository\BookingsRepository;
use App\Infrastructure\Data\Repository\InsurancesRepository;
use App\Infrastructure\Factories\RepositoryFactory;
use App\Infrastructure\Handler\ActionHandler;
use App\Infrastructure\Handler\ListCanceledBookingsHandler;
use App\Infrastructure\Handler\ListInsuredBookingsHandler;
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
            RepositoryFactory::class     => [
                ActionsRepository::class    => Actions::class,
                BookingsRepository::class   => Bookings::class,
                InsurancesRepository::class => Insurances::class,
            ],
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
                ActionsRepository::class                => RepositoryFactory::class,
                BookingsRepository::class               => RepositoryFactory::class,
                InsurancesRepository::class             => RepositoryFactory::class,
            ],
            'abstract_factories' => [
                ConfigAbstractFactory::class,
            ],
            'aliases'            => [],
        ];
    }

    private function getAbstractFactories(): array
    {
        return [
            ActionHandler::class                => [
                ProcessActionUseCase::class,
            ],
            ProcessActionUseCase::class         => [
                GetBookingService::class,
                ValidateActionService::class,
                CreateInsuranceService::class,
                CancelBookingsService::class,
            ],
            GetBookingService::class            => [
                BookingsRepository::class,
            ],
            ValidateActionService::class        => [
                ActionsRepository::class,
            ],
            CreateInsuranceService::class       => [
                InsurancesRepository::class,
                BookingsRepository::class,
            ],
            CancelBookingsService::class        => [
                BookingsRepository::class,
            ],
            ListCanceledBookingsHandler::class  => [
                ListCancelledBookingsUseCase::class,
            ],
            ListCancelledBookingsUseCase::class => [
                ListCancelledBookingsService::class,
            ],
            ListCancelledBookingsService::class => [
                BookingsRepository::class,
            ],
            ListInsuredBookingsHandler::class   => [
                ListInsuredBookingsUseCase::class,
            ],
            ListInsuredBookingsUseCase::class   => [
                ListInsuredBookingsService::class,
            ],
            ListInsuredBookingsService::class   => [
                BookingsRepository::class,
            ],
        ];
    }
}
