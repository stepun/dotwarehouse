<?php

declare(strict_types=1);

namespace Api\Cabinet\Handler;

use Api\App\Handler\HandlerTrait;
use Api\App\Logger\Log;
use Api\Cabinet\Entity\Warehouse;
use Api\Cabinet\InputFilter\WarehouseInputFilter;
use Api\Cabinet\Service\WarehouseServiceInterface;
use Api\User\Service\UserServiceInterface;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use Dot\DependencyInjection\Attribute\Inject;
use Psr\Http\Server\RequestHandlerInterface;

class WarehouseHandler implements RequestHandlerInterface
{
    use HandlerTrait;

    #[Inject(
        WarehouseServiceInterface::class,
        "config",
        HalResponseFactory::class,
        ResourceGenerator::class,
    )]
    public function __construct(
        protected WarehouseServiceInterface $warehouseService,
        protected array $config,
        protected HalResponseFactory $responseFactory,
        protected ResourceGenerator $resourceGenerator,
    ) {
    }

    public function get(ServerRequestInterface $request): ResponseInterface
    {
        $warehouse = $this->warehouseService->getRepository()->findOneBy(['uuid' => $request->getAttribute('uuid')]);

        if (! $warehouse instanceof Warehouse){
            return $this->notFoundResponse();
        }

        return $this->createResponse($request, $warehouse);
    }

    public function getCollection(ServerRequestInterface $request): ResponseInterface
    {
        Log::add('getCollection');
        $warehouses = $this->warehouseService->getRepository()->getWarehouses($request->getQueryParams());

        return $this->createResponse($request, $warehouses);
    }

    public function post(ServerRequestInterface $request): ResponseInterface
    {
        Log::add('post');
        $inputFilter = (new WarehouseInputFilter())->setData($request->getParsedBody());
        if (! $inputFilter->isValid()) {
            return $this->errorResponse($inputFilter->getMessages(), StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY);
        }

        $book = $this->warehouseService->createWarehouse($inputFilter->getValues());

        return $this->createResponse($request, $book);
    }
}
