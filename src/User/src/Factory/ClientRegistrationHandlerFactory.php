<?php

declare(strict_types=1);

namespace Api\User\Factory;

use Api\User\Handler\ClientRegistrationHandler;
use Api\User\InputFilter\ClientRegistrationInputFilter;
use Api\User\Service\ClientRegistrationService;
use Mezzio\Router\RouterInterface;
use Psr\Container\ContainerInterface;

class ClientRegistrationHandlerFactory
{
    public function __invoke(ContainerInterface $container): ClientRegistrationHandler
    {
        return new ClientRegistrationHandler(
            $container->get(RouterInterface::class),
            $container->get(ClientRegistrationService::class),
            $container->get(ClientRegistrationInputFilter::class)
        );
    }
} 