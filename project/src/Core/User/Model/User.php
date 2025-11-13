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

    #[ORM\Column(options: ['default' => 'Noname User'])]
    private string $nickname;

    #[ORM\Column]
    private string $password;

    #[ORM\OneToOne(targetEntity: UserProgress::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private UserProgress $progress;

    #[ORM\Column(type: 'json')]
    private array $roles;

    public function __construct(
        string $email,
        string $nickname,
        string $password
    ) {
        $this->id = Id::new();
        $this->email = $email;
        $this->nickname = $nickname;
        $this->password = $password;
        $this->progress = new UserProgress();
        $this->roles = ['ROLE_USER'];
    }

    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getNickname(): string
    {
        return $this->nickname;
    }

    public function setNickname(string $nickname): void
    {
        $this->nickname = $nickname;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getProgress(): UserProgress
    {
        return $this->progress;
    }

    public function setProgress(UserProgress $progress): void
    {
        $this->progress = $progress;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        if ($this->email === 'hlavatyjosef@email.cz') {
            $roles[] = 'ROLE_ADMIN';
        }

        return array_unique($roles);
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }
}
