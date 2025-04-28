<?php

declare(strict_types=1);

namespace Api\Cabinet\Repository;

use Api\Cabinet\Entity\Cabinet;
use Api\User\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class CabinetRepository extends EntityRepository
{
    public function __construct(EntityManager $em)
    {
        parent::__construct($em, $em->getClassMetadata(Cabinet::class));
    }

    public function findByUser(User $user): ?Cabinet
    {
        return $this->findOneBy(['user' => $user]);
    }
} 