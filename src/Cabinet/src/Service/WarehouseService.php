<?php

declare(strict_types=1);

namespace Api\Cabinet\Service;

use Api\Cabinet\Entity\Cabinet;
use Api\Cabinet\Entity\Warehouse;
use Api\Cabinet\Repository\WarehouseRepository;
use Doctrine\ORM\EntityManager;
use Ramsey\Uuid\Uuid;

class WarehouseService
{
    public function __construct(
        protected EntityManager $entityManager,
        protected WarehouseRepository $warehouseRepository
    ) {
    }

    public function createDefaultWarehouse(Cabinet $cabinet): Warehouse
    {
        $warehouse = new Warehouse();
        $warehouse->setUuid(Uuid::uuid4());
        $warehouse->setCabinet($cabinet);
        $warehouse->setName('Основной склад');
        $warehouse->setType('main');
        $warehouse->setIdentifier('MAIN-' . $cabinet->getUuid()->toString());
        $warehouse->setCreatedAt(new \DateTime());

        $this->entityManager->persist($warehouse);
        $this->entityManager->flush();

        return $warehouse;
    }

    public function findByCabinet(Cabinet $cabinet): array
    {
        return $this->warehouseRepository->findByCabinet($cabinet);
    }
}
