<?php

declare(strict_types=1);

namespace App\Core\Quiz\Model;

use App\Core\Shared\Model\Entity;
use App\Core\Shared\Model\EntityTrait;
use App\Core\Shared\Model\Id;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
final class Quiz implements Entity
{
use EntityTrait;

    public function __construct()
    {
        $this->id = Id::new();
    }
}