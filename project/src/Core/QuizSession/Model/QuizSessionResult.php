<?php

declare(strict_types=1);

namespace App\Core\QuizSession\Model;

use App\Core\Shared\Model\Entity;
use App\Core\Shared\Model\EntityTrait;
use App\Core\Shared\Model\Id;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class QuizSessionResult implements Entity
{
    use EntityTrait;

    public const SESSION = 'session';

    #[ORM\OneToOne(targetEntity: QuizSession::class, inversedBy: QuizSession::RESULT)]
    #[ORM\JoinColumn(onDelete: 'CASCADE')]
    private QuizSession $session;

    #[ORM\Column(type: Types::INTEGER, options: ['default' => 0])]
    private int $score;

    public function __construct(
        QuizSession $session,
        int $score,
    ) {
        $this->id = Id::new();
        $this->session = $session;
        $this->score = $score;
    }

    public function getSession(): QuizSession
    {
        return $this->session;
    }

    public function setSession(QuizSession $session): void
    {
        $this->session = $session;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function setScore(int $score): void
    {
        $this->score = $score;
    }

    public function addScore(int $points): void
    {
        $this->score += $points;
    }
}
