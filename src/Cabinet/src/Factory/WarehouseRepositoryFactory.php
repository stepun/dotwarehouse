<?php

declare(strict_types=1);

namespace Api\Cabinet\Factory;

use Api\Cabinet\Repository\WarehouseRepository;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;

class WarehouseRepositoryFactory
{
    public function __invoke(ContainerInterface $container): WarehouseRepository
    {
        return new WarehouseRepository(
            $container->get(EntityManager::class)
        );
    }
} 