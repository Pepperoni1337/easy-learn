<?php

declare(strict_types=1);

namespace App\Core\QuizSession\Model;

use App\Core\Shared\Model\Entity;
use App\Core\Shared\Model\EntityTrait;
use App\Core\Shared\Model\Id;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class QuizSessionProgress implements Entity
{
    use EntityTrait;

    public const CURRENT_LEVEL = 'current_level';
    public const SCORE = 'score';
    public const CURRENT_STREAK = 'current_streak';
    public const MAX_STREAK = 'max_streak';

    #[ORM\Column(type: Types::INTEGER)]
    private int $currentLevel;

    #[ORM\Column(type: Types::INTEGER)]
    private int $score;

    #[ORM\Column(type: Types::INTEGER)]
    private int $currentStreak;

    #[ORM\Column(type: Types::INTEGER)]
    private int $maxStreak;

    public static function createEmpty(): self {
        return new self(1, 0, 0, 0);
    }

    public function __construct(
        int $currentLevel,
        int $score,
        int $currentStreak,
        int $maxStreak,
    ) {
        $this->id = Id::new();
        $this->currentLevel = $currentLevel;
        $this->score = $score;
        $this->currentStreak = $currentStreak;
        $this->maxStreak = $maxStreak;
    }

    public function getCurrentLevel(): int
    {
        return $this->currentLevel;
    }

    public function setCurrentLevel(int $currentLevel): void
    {
        $this->currentLevel = $currentLevel;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function setScore(int $score): void
    {
        $this->score = $score;
    }

    public function getCurrentStreak(): int
    {
        return $this->currentStreak;
    }

    public function setCurrentStreak(int $currentStreak): void
    {
        $this->currentStreak = $currentStreak;
    }

    public function getMaxStreak(): int
    {
        return $this->maxStreak;
    }

    public function setMaxStreak(int $maxStreak): void
    {
        $this->maxStreak = $maxStreak;
    }
}