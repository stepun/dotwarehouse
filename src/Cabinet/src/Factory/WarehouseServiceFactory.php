<?php

declare(strict_types=1);

namespace Api\Cabinet\Factory;

use Api\Cabinet\Repository\WarehouseRepository;
use Api\Cabinet\Service\WarehouseService;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;

class WarehouseServiceFactory
{
    public function __invoke(ContainerInterface $container): WarehouseService
    {
        return new WarehouseService(
            $container->get(EntityManager::class),
            $container->get(WarehouseRepository::class)
        );
    }
} 