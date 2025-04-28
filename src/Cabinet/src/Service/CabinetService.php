<?php

declare(strict_types=1);

namespace Api\Cabinet\Service;

use Api\Cabinet\Entity\Cabinet;
use Api\Cabinet\Repository\CabinetRepository;
use Api\User\Entity\User;
use Doctrine\ORM\EntityManager;
use Ramsey\Uuid\Uuid;

class CabinetService
{
    public function __construct(
        protected EntityManager $entityManager,
        protected CabinetRepository $cabinetRepository
    ) {
    }

    public function createCabinet(User $user, string $name): Cabinet
    {
        $cabinet = new Cabinet();
        $cabinet->setUuid(Uuid::uuid4());
        $cabinet->setName($name);
        $cabinet->setStatus('active');
        $cabinet->setUser($user);
        $cabinet->setCreatedAt(new \DateTime());

        $this->entityManager->persist($cabinet);
        $this->entityManager->flush();

        return $cabinet;
    }

    public function findByUser(User $user): ?Cabinet
    {
        return $this->cabinetRepository->findByUser($user);
    }
} 