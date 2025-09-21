<?php

declare(strict_types=1);

namespace App\Core\Quiz\Model;

use App\Core\Shared\Model\Entity;
use App\Core\Shared\Model\EntityTrait;
use App\Core\Shared\Model\Id;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Quiz implements Entity
{
    use EntityTrait;

    public const TITLE = 'title';
    public const DESCRIPTION = 'description';

    #[ORM\Column]
    private string $title;

    #[ORM\Column]
    private string $description;

    public function __construct(
        string $title,
        string $description,
    ) {
        $this->id = Id::new();
        $this->title = $title;
        $this->description = $description;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
}
