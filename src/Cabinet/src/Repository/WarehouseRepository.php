<?php

declare(strict_types=1);

namespace Api\Cabinet\Repository;

use Api\App\Helper\PaginationHelper;
use Api\App\Logger\Log;
use Api\Cabinet\Collection\WarehouseCollection;
use Api\Cabinet\Entity\Warehouse;
use Doctrine\ORM\EntityRepository;
use Dot\DependencyInjection\Attribute\Entity;
use Api\Cabinet\Entity\Cabinet;
use Doctrine\ORM\EntityManager;

#[Entity(name: Warehouse::class)]
class WarehouseRepository extends EntityRepository
{
    public function __construct(EntityManager $em)
    {
        parent::__construct($em, $em->getClassMetadata(Warehouse::class));
    }

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

    public function findByCabinet(Cabinet $cabinet): array
    {
        return $this->findBy(['cabinet' => $cabinet]);
    }
}
