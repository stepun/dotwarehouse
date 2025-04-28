<?php

declare(strict_types=1);

namespace Api\User\Factory;

use Api\Cabinet\Service\CabinetService;
use Api\Cabinet\Service\WarehouseService;
use Api\User\Service\ClientRegistrationService;
use Api\User\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;

class ClientRegistrationServiceFactory
{
    public function __invoke(ContainerInterface $container): ClientRegistrationService
    {
        return new ClientRegistrationService(
            $container->get(EntityManager::class),
            $container->get(UserRepository::class),
            $container->get(CabinetService::class),
            $container->get(WarehouseService::class)
        );
    }
} 