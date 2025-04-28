<?php

declare(strict_types=1);

namespace Api\Cabinet\Factory;

use Api\Cabinet\Repository\CabinetRepository;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;

class CabinetRepositoryFactory
{
    public function __invoke(ContainerInterface $container): CabinetRepository
    {
        return new CabinetRepository(
            $container->get(EntityManager::class)
        );
    }
} 