<?php

namespace App\Core\Shared\Model;

use Doctrine\ORM\Mapping as ORM;

trait EntityTrait
{
    #[ORM\Id]
    #[ORM\Column(type: 'id', unique: true)]
    private Id $id;

    public function getId(): Id
    {
        return $this->id;
    }
}