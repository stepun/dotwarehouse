<?php

declare(strict_types=1);

namespace Api\User\Service;

use Api\Cabinet\Service\CabinetService;
use Api\Cabinet\Service\WarehouseService;
use Api\User\Entity\User;
use Api\User\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Ramsey\Uuid\Uuid;

class ClientRegistrationService
{
    public function __construct(
        protected EntityManager $entityManager,
        protected UserRepository $userRepository,
        protected CabinetService $cabinetService,
        protected WarehouseService $warehouseService
    ) {
    }

    public function registerClient(string $identity, string $password, string $cabinetName): array
    {
        // Создаем пользователя
        $user = new User();
        $user->setUuid(Uuid::uuid4());
        $user->setIdentity($identity);
        $user->setPassword(password_hash($password, PASSWORD_DEFAULT));
        $user->setStatus('active');
        $user->setIsDeleted(false);
        $user->setHash(bin2hex(random_bytes(32)));
        $user->setCreated(new \DateTime());

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        // Создаем кабинет для пользователя
        $cabinet = $this->cabinetService->createCabinet($user, $cabinetName);

        // Создаем склад по умолчанию
        $warehouse = $this->warehouseService->createDefaultWarehouse($cabinet);

        return [
            'user' => $user,
            'cabinet' => $cabinet,
            'warehouse' => $warehouse
        ];
    }
} 