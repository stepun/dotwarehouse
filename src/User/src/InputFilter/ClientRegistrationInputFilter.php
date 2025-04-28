<?php

declare(strict_types=1);

namespace Api\User\InputFilter;

use Laminas\InputFilter\InputFilter;

class ClientRegistrationInputFilter extends InputFilter
{
    public function init()
    {
        $this->add([
            'name' => 'identity',
            'required' => true,
            'filters' => [
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 3,
                        'max' => 100,
                    ],
                ],
                [
                    'name' => 'Regex',
                    'options' => [
                        'pattern' => '/^[a-zA-Z0-9_]+$/',
                        'messages' => [
                            'regexNotMatch' => 'Идентификатор может содержать только буквы, цифры и символ подчеркивания',
                        ],
                    ],
                ],
            ],
        ]);

        $this->add([
            'name' => 'password',
            'required' => true,
            'filters' => [
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 8,
                        'max' => 100,
                    ],
                ],
            ],
        ]);

        $this->add([
            'name' => 'cabinetName',
            'required' => true,
            'filters' => [
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 3,
                        'max' => 191,
                    ],
                ],
            ],
        ]);
    }
} 