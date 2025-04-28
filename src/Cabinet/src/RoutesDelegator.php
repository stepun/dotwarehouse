<?php

declare(strict_types=1);

namespace Api\Cabinet;

use Api\App\Logger\Log;
use Api\Cabinet\Handler\WarehouseCollectionHandler;
use Api\Cabinet\Handler\WarehouseHandler;
use Mezzio\Application;
use Psr\Container\ContainerInterface;

class RoutesDelegator
{
    public function __invoke(ContainerInterface $container, string $serviceName, callable $callback): Application
    {
        /** @var Application $app */
        $app = $callback();
        $uuid = \Api\App\RoutesDelegator::REGEXP_UUID;
        Log::add($uuid);
        $app->get(
            '/warehouses',
            WarehouseCollectionHandler::class,
            'warehouses.list'
        );
        $app->get(
            '/warehouse/'.$uuid,
            WarehouseHandler::class,
            'warehouse.show'
        );
        $app->post(
            '/warehouse',
            WarehouseHandler::class,
            'warehouse.create'
        );

        return $app;
    }
}
