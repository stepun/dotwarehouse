<?php

declare(strict_types=1);

namespace Api\Cabinet;

use Api\App\Logger\Log;
use Api\Cabinet\Collection\WarehouseCollection;
use Api\Cabinet\Entity\Warehouse;
use Api\Cabinet\Handler\WarehouseCollectionHandler;
use Api\Cabinet\Handler\WarehouseHandler;
use Api\Cabinet\Repository\WarehouseRepository;
use Api\Cabinet\Service\WarehouseService;
use Api\Cabinet\Service\WarehouseServiceInterface;
use Doctrine\ORM\Mapping\Driver\AttributeDriver;
use Dot\DependencyInjection\Factory\AttributedRepositoryFactory;
use Dot\DependencyInjection\Factory\AttributedServiceFactory;
use Mezzio\Application;
use Mezzio\Hal\Metadata\MetadataMap;
use Api\App\ConfigProvider as AppConfigProvider;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies'     => $this->getDependencies(),
            'doctrine'     => $this->getDoctrineConfig(),
            MetadataMap::class => $this->getHalConfig(),
        ];
    }

    private function getDependencies(): array
    {
        return [
            'delegators' => [
                Application::class => [
                    RoutesDelegator::class
                ]
            ],
            'factories' => [
                WarehouseHandler::class    => AttributedServiceFactory::class,
                WarehouseCollectionHandler::class       => AttributedServiceFactory::class,
                WarehouseService::class    => AttributedServiceFactory::class,
                WarehouseRepository::class => AttributedRepositoryFactory::class,
                \Api\Cabinet\Service\CabinetService::class => \Api\Cabinet\Factory\CabinetServiceFactory::class,
                \Api\Cabinet\Service\WarehouseService::class => \Api\Cabinet\Factory\WarehouseServiceFactory::class,
                \Api\Cabinet\Repository\CabinetRepository::class => \Api\Cabinet\Factory\CabinetRepositoryFactory::class,
                \Api\Cabinet\Repository\WarehouseRepository::class => \Api\Cabinet\Factory\WarehouseRepositoryFactory::class,
            ],
            'aliases'   => [
                WarehouseServiceInterface::class     => WarehouseService::class,
            ],
        ];
    }

    private function getDoctrineConfig(): array
    {
        return [
            'driver' => [
                'orm_default'   => [
                    'drivers' => [
                        'Api\Cabinet\Entity' => 'WarehouseEntities'
                    ],
                ],
                'WarehouseEntities'  => [
                    'class' => AttributeDriver::class,
                    'cache' => 'array',
                    'paths' => __DIR__ . '/Entity',
                ],
            ],
        ];
    }

    private function getHalConfig(): array
    {
        return [
            AppConfigProvider::getCollection(WarehouseCollection::class, 'warehouses.list', 'warehouse'),
            AppConfigProvider::getResource(Warehouse::class, 'warehouse.show')
        ];
    }

}
