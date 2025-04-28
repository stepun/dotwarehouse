<?php

declare(strict_types=1);

namespace Api\Cabinet\Service;
use Api\Cabinet\Entity\Warehouse;
use Api\Cabinet\Repository\WarehouseRepository;
use Dot\DependencyInjection\Attribute\Inject;

class WarehouseService implements WarehouseServiceInterface
{
    #[Inject(WarehouseRepository::class)]
    public function __construct(protected WarehouseRepository $warehouseRepository)
    {
    }
    public function getRepository(): WarehouseRepository
    {
        return $this->warehouseRepository;
    }

    public function createWarehouse(array $data): Warehouse
    {
        $book = new Warehouse(
            $data['name']
        );

        return $this->warehouseRepository->save($book);
    }

    public function getWarehouses(array $filters = [])
    {
        return $this->warehouseRepository->getWarehouses($filters);
    }
}
