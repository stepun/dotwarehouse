<?php

declare(strict_types=1);

namespace Api\Cabinet\InputFilter;

use Api\Cabinet\InputFilter\Input\NameInput;
use Laminas\InputFilter\InputFilter;

class WarehouseInputFilter extends InputFilter
{
    public function __construct()
    {
        $this->add(new NameInput('name'));
    }
}
