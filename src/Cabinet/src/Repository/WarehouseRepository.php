<?php

namespace Api\Cabinet\Repository;

use Api\App\Helper\PaginationHelper;
use Api\App\Logger\Log;
use Api\Cabinet\Collection\WarehouseCollection;
use Api\Cabinet\Entity\Warehouse;
use Doctrine\ORM\EntityRepository;
use Dot\DependencyInjection\Attribute\Entity;

#[Entity(name: Warehouse::class)]
class WarehouseRepository extends EntityRepository
{
    public function save(Warehouse $warehouse): Warehouse
    {
        $this->getEntityManager()->persist($warehouse);
        $this->getEntityManager()->flush();

        return $warehouse;
    }

    public function getWarehouses(array $filters = []): WarehouseCollection
    {
        $page = PaginationHelper::getOffsetAndLimit($filters);

        $qb = $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('warehouse')
            ->from(Warehouse::class, 'warehouse')
            ->orderBy($filters['order'] ?? 'warehouse.created', $filters['dir'] ?? 'desc')
            ->setFirstResult($page['offset'])
            ->setMaxResults($page['limit']);

        $qb->getQuery()->useQueryCache(true);

        return new WarehouseCollection($qb, false);
    }
}
