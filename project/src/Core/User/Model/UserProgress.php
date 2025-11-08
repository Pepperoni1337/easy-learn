<?php

declare(strict_types=1);

namespace App\Core\User\Model;

use App\Core\Shared\Model\Entity;
use App\Core\Shared\Model\EntityTrait;
use App\Core\Shared\Model\Id;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
final class UserProgress implements Entity
{
    use EntityTrait;

    public const USER = 'user';
    public const SCORE = 'score';
    public const LEVEL = 'level';
    public const NUMBER_OF_FINISHED_SESSIONS = 'number_of_finished_sessions';
    public const NUMBER_OF_CORRECT_ANSWERS = 'number_of_correct_answers';

    #[ORM\ManyToOne(targetEntity: User::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private User $user;

    #[ORM\Column(type: Types::INTEGER)]
    private int $score;

    #[ORM\Column(type: Types::INTEGER)]
    private int $level;

    #[ORM\Column(type: Types::INTEGER)]
    private int $numberOfFinishedSessions;

    #[ORM\Column(type: Types::INTEGER)]
    private int $numberOfCorrectAnswers;

    public function __construct(
        User $user,
        int $score = 0,
        int $level = 0,
        int $numberOfFinishedSessions = 0,
        int $numberOfCorrectAnswers = 0,
    ) {
        $this->id = Id::new();
        $this->user = $user;
        $this->score = $score;
        $this->level = $level;
        $this->numberOfFinishedSessions = $numberOfFinishedSessions;
        $this->numberOfCorrectAnswers = $numberOfCorrectAnswers;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function setScore(int $score): void
    {
        $this->score = $score;
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    public function setLevel(int $level): void
    {
        $this->level = $level;
    }

    public function getNumberOfFinishedSessions(): int
    {
        return $this->numberOfFinishedSessions;
    }

    public function setNumberOfFinishedSessions(int $numberOfFinishedSessions): void
    {
        $this->numberOfFinishedSessions = $numberOfFinishedSessions;
    }

    public function getNumberOfCorrectAnswers(): int
    {
        return $this->numberOfCorrectAnswers;
    }

    public function setNumberOfCorrectAnswers(int $numberOfCorrectAnswers): void
    {
        $this->numberOfCorrectAnswers = $numberOfCorrectAnswers;
    }
}
