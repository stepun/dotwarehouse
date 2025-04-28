<?php

namespace Api\Cabinet\Handler;

use Api\App\Exception\BadRequestException;
use Api\App\Handler\HandlerTrait;
use Dot\DependencyInjection\Attribute\Inject;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Api\Cabinet\Entity\Warehouse;
use Api\Cabinet\Service\WarehouseServiceInterface;
use Psr\Http\Message\ResponseInterface;

class WarehouseCollectionHandler implements RequestHandlerInterface
{
    use HandlerTrait;

    #[Inject(
        HalResponseFactory::class,
        ResourceGenerator::class,
        WarehouseServiceInterface::class,
    )]
    public function __construct(
        protected HalResponseFactory $responseFactory,
        protected ResourceGenerator $resourceGenerator,
        protected WarehouseServiceInterface $warehouseService
    ) {
    }

    /**
     * @throws BadRequestException
     */
    public function get(ServerRequestInterface $request): ResponseInterface
    {
        return $this->createResponse($request, $this->warehouseService->getWarehouses($request->getQueryParams()));
    }
}
