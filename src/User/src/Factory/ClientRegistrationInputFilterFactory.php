<?php

declare(strict_types=1);

namespace Api\User\Factory;

use Api\User\InputFilter\ClientRegistrationInputFilter;
use Psr\Container\ContainerInterface;

class ClientRegistrationInputFilterFactory
{
    public function __invoke(ContainerInterface $container): ClientRegistrationInputFilter
    {
        $inputFilter = new ClientRegistrationInputFilter();
        $inputFilter->init();
        return $inputFilter;
    }
} 