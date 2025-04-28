<?php

declare(strict_types=1);

namespace Api\User\Handler;

use Api\User\InputFilter\ClientRegistrationInputFilter;
use Api\User\Service\ClientRegistrationService;
use Laminas\Diactoros\Response\JsonResponse;
use Mezzio\Router\RouterInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ClientRegistrationHandler implements MiddlewareInterface
{
    public function __construct(
        protected RouterInterface $router,
        protected ClientRegistrationService $clientRegistrationService,
        protected ClientRegistrationInputFilter $inputFilter
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $data = $request->getParsedBody();

        $this->inputFilter->setData($data);

        if (!$this->inputFilter->isValid()) {
            return new JsonResponse([
                'status' => 'error',
                'messages' => $this->inputFilter->getMessages(),
            ], 400);
        }

        $validData = $this->inputFilter->getValues();

        try {
            $result = $this->clientRegistrationService->registerClient(
                $validData['identity'],
                $validData['password'],
                $validData['cabinetName']
            );

            return new JsonResponse([
                'status' => 'success',
                'data' => [
                    'user' => [
                        'uuid' => $result['user']->getUuid()->toString(),
                        'identity' => $result['user']->getIdentity(),
                        'status' => $result['user']->getStatus(),
                    ],
                    'cabinet' => [
                        'uuid' => $result['cabinet']->getUuid()->toString(),
                        'name' => $result['cabinet']->getName(),
                        'status' => $result['cabinet']->getStatus(),
                    ],
                    'warehouse' => [
                        'uuid' => $result['warehouse']->getUuid()->toString(),
                        'name' => $result['warehouse']->getName(),
                        'type' => $result['warehouse']->getType(),
                        'identifier' => $result['warehouse']->getIdentifier(),
                    ],
                ],
            ], 201);
        } catch (\Exception $e) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'Ошибка при регистрации клиента: ' . $e->getMessage(),
            ], 500);
        }
    }
} 