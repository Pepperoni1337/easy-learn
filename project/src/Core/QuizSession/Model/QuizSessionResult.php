<?php

declare(strict_types=1);

namespace App\Core\QuizSession\Model;

use App\Core\Shared\Model\Entity;
use App\Core\Shared\Model\EntityTrait;
use App\Core\Shared\Model\Id;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class QuizSessionResult implements Entity
{
    use EntityTrait;

    public const SESSION = 'session';

    #[ORM\OneToOne(targetEntity: QuizSession::class, inversedBy: QuizSession::RESULT)]
    #[ORM\JoinColumn(onDelete: 'CASCADE')]
    private QuizSession $session;

    public function __construct(
        QuizSession $session,
    ) {
        $this->id = Id::new();
        $this->session = $session;
    }

    public function getSession(): QuizSession
    {
        return $this->session;
    }

    public function setSession(QuizSession $session): void
    {
        $this->session = $session;
    }
}