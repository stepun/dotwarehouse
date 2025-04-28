<?php

namespace Api\Cabinet\Entity;

use Api\App\Entity\AbstractEntity;
use Api\App\Entity\TimestampsTrait;
use Api\Cabinet\Repository\WarehouseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WarehouseRepository::class)]
#[ORM\Table("warehouse")]
#[ORM\HasLifecycleCallbacks]
class Warehouse extends AbstractEntity
{
    use TimestampsTrait;

    #[ORM\Column(name: "name", type: "string", length: 100)]
    protected string $name;

    public function __construct(string $name)
    {
        parent::__construct();

        $this->setName($name);
    }

    public function getArrayCopy()
    {
        return [
            'uuid' => $this->getUuid()->toString(),
            'name' => $this->getName(),
        ];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
