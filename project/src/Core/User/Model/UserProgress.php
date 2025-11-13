<?php

declare(strict_types=1);

namespace App\Core\User\Model;

use App\Core\Shared\Model\Entity;
use App\Core\Shared\Model\EntityTrait;
use App\Core\Shared\Model\Id;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class UserProgress implements Entity
{
    use EntityTrait;

    public const SCORE = 'score';
    public const LEVEL = 'level';
    public const NUMBER_OF_FINISHED_SESSIONS = 'numberOfFinishedSessions';
    public const NUMBER_OF_CREATED_QUIZZES = 'numberOfCreatedQuizzes';

    #[ORM\Column(type: Types::INTEGER)]
    private int $score;

    #[ORM\Column(type: Types::INTEGER)]
    private int $level;

    #[ORM\Column(type: Types::INTEGER)]
    private int $numberOfFinishedSessions;

    #[ORM\Column(type: Types::INTEGER)]
    private int $numberOfCreatedQuizzes;

    public function __construct(
        int $score = 0,
        int $level = 0,
        int $numberOfFinishedSessions = 0,
        int $numberOfCreatedQuizzes = 0,
    ) {
        $this->id = Id::new();
        $this->score = $score;
        $this->level = $level;
        $this->numberOfFinishedSessions = $numberOfFinishedSessions;
        $this->numberOfCreatedQuizzes = $numberOfCreatedQuizzes;
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

    public function getNumberOfCreatedQuizzes(): int
    {
        return $this->numberOfCreatedQuizzes;
    }

    public function setNumberOfCreatedQuizzes(int $numberOfCreatedQuizzes): void
    {
        $this->numberOfCreatedQuizzes = $numberOfCreatedQuizzes;
    }
}
