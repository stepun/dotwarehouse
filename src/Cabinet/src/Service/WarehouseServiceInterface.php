<?php

declare(strict_types=1);

namespace Api\Cabinet\Service;

use Api\Cabinet\Repository\WarehouseRepository;

interface WarehouseServiceInterface
{
    public function getRepository(): WarehouseRepository;
}
