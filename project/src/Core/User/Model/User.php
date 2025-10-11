<?php

declare(strict_types=1);

namespace App\Core\User\Model;

use App\Core\Shared\Model\Entity;
use App\Core\Shared\Model\EntityTrait;
use App\Core\Shared\Model\Id;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity]
class User implements Entity, UserInterface, PasswordAuthenticatedUserInterface
{
    use EntityTrait;

    #[ORM\Column(unique: true)]
    private string $email;

    public function __construct()
    {
        $this->id = Id::new();
    }

    public function getRoles(): array
    {
        return [
            'ROLE_USER',
            'ROLE_ADMIN',
        ];
    }

    public function eraseCredentials(): void
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getPassword(): ?string
    {
        return 'abc';
    }
}
