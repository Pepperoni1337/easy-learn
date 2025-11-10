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

    public const CURRENT_LEVEL = 'currentLevel';
    public const SCORE = 'score';
    public const NUMBER_OF_CORRECT_ANSWERS = 'numberOfCorrectAnswers';
    public const NUMBER_OF_WRONG_ANSWERS = 'numberOfWrongAnswers';
    public const CURRENT_STREAK = 'currentStreak';
    public const MAX_STREAK = 'maxStreak';

    #[ORM\Column(type: Types::INTEGER)]
    private int $currentLevel;

    #[ORM\Column(type: Types::INTEGER)]
    private int $score;

    #[ORM\Column(type: Types::INTEGER, options: ['default' => 0])]
    private int $numberOfCorrectAnswers;

    #[ORM\Column(type: Types::INTEGER, options: ['default' => 0])]
    private int $numberOfWrongAnswers;

    #[ORM\Column(type: Types::INTEGER)]
    private int $currentStreak;

    #[ORM\Column(type: Types::INTEGER)]
    private int $maxStreak;

    public static function createEmpty(): self
    {
        return new self(1);
    }

    private function __construct(
        int $currentLevel,
        int $score = 0,
        int $numberOfCorrectAnswers = 0,
        int $numberOfWrongAnswers = 0,
        int $currentStreak = 0,
        int $maxStreak = 0,
    ) {
        $this->id = Id::new();
        $this->currentLevel = $currentLevel;
        $this->score = $score;
        $this->numberOfCorrectAnswers = $numberOfCorrectAnswers;
        $this->numberOfWrongAnswers = $numberOfWrongAnswers;
        $this->currentStreak = $currentStreak;
        $this->maxStreak = $maxStreak;
    }

    public function getCurrentLevel(): int
    {
        return $this->currentLevel;
    }

    public function increaseCurrentLevel(): void
    {
        $this->currentLevel++;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function increaseScore(int $diff): void
    {
        $this->score += $diff;
    }

    public function getNumberOfCorrectAnswers(): int
    {
        return $this->numberOfCorrectAnswers;
    }

    public function increaseNumberOfCorrectAnswers(): void
    {
        $this->numberOfCorrectAnswers++;
    }

    public function getNumberOfWrongAnswers(): int
    {
        return $this->numberOfWrongAnswers;
    }

    public function increaseNumberOfWrongAnswers(): void
    {
        $this->numberOfWrongAnswers++;
    }

    public function getCurrentStreak(): int
    {
        return $this->currentStreak;
    }

    public function increaseCurrentStreak(): void
    {
        $this->currentStreak++;
        $this->maxStreak = max($this->maxStreak, $this->currentStreak);
    }

    public function resetCurrentStreak(): void
    {
        $this->currentStreak = 0;
    }

    public function getMaxStreak(): int
    {
        return $this->maxStreak;
    }
}
