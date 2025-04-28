<?php

declare(strict_types=1);

namespace Api\Cabinet\Factory;

use Api\Cabinet\Repository\CabinetRepository;
use Api\Cabinet\Service\CabinetService;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;

class CabinetServiceFactory
{
    public function __invoke(ContainerInterface $container): CabinetService
    {
        return new CabinetService(
            $container->get(EntityManager::class),
            $container->get(CabinetRepository::class)
        );
    }
} 