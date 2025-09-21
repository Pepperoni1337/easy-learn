<?php

declare(strict_types=1);

namespace App\Core\User\Model;

use App\Core\Shared\Model\Entity;
use App\Core\Shared\Model\EntityTrait;
use App\Core\Shared\Model\Id;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class User implements Entity
{
    use EntityTrait;

    public function __construct()
    {
        $this->id = Id::new();
    }
}
