<?php

namespace Api\Cabinet\Collection;

use Api\App\Collection\ResourceCollection;
use Api\Cabinet\Entity\Warehouse;

class WarehouseCollection extends ResourceCollection
{
    public function getCollectionDefinition(): array
    {
        return [
            'type' => Warehouse::class,
            'links' => [],
        ];
    }
}
