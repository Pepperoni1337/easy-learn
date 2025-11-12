<?php

declare(strict_types=1);

namespace App\Core\QuizSession\Model;

use App\Core\Quiz\Model\Quiz;
use App\Core\Shared\Model\Entity;
use App\Core\Shared\Model\EntityTrait;
use App\Core\Shared\Model\Id;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class QuizSessionResult implements Entity
{
    use EntityTrait;

    public const Quiz = 'quiz';
    public const SESSION = 'session';
    public const TOTAL_SCORE = 'totalScore';
    public const TOTAL_TIME = 'totalTime';
    public const NUMBER_OF_CORRECT_ANSWERS = 'numberOfCorrectAnswers';
    public const NUMBER_OF_WRONG_ANSWERS = 'numberOfWrongAnswers';

    #[ORM\ManyToOne(targetEntity: Quiz::class)]
    #[ORM\JoinColumn(onDelete: 'CASCADE')]
    private Quiz $quiz;

    #[ORM\OneToOne(targetEntity: QuizSession::class, inversedBy: QuizSession::RESULT)]
    #[ORM\JoinColumn(onDelete: 'CASCADE')]
    private QuizSession $session;

    #[ORM\Column(type: Types::INTEGER, options: ['default' => 0])]
    private int $totalScore;

    #[ORM\Column(type: Types::FLOAT, options: ['default' => 0.0])]
    private float $totalTime;

    #[ORM\Column(type: Types::INTEGER, options: ['default' => 0])]
    private int $numberOfCorrectAnswers;

    #[ORM\Column(type: Types::INTEGER, options: ['default' => 0])]
    private int $numberOfWrongAnswers;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, options: ['default' => 'CURRENT_TIMESTAMP'])]
    private DateTimeImmutable $finishedAt;

    public function __construct(
        Quiz $quiz,
        QuizSession $session,
        int $totalScore,
        float $totalTime,
        int $numberOfCorrectAnswers,
        int $numberOfWrongAnswers,
        DateTimeImmutable $finishedAt,
    ) {
        $this->id = Id::new();
        $this->quiz = $quiz;
        $this->session = $session;
        $this->totalScore = $totalScore;
        $this->totalTime = $totalTime;
        $this->numberOfCorrectAnswers = $numberOfCorrectAnswers;
        $this->numberOfWrongAnswers = $numberOfWrongAnswers;
        $this->finishedAt = $finishedAt;
    }

    public function getQuiz(): Quiz
    {
        return $this->quiz;
    }

    public function getSession(): QuizSession
    {
        return $this->session;
    }

    public function getTotalScore(): int
    {
        return $this->totalScore;
    }

    public function getTotalTime(): float
    {
        return $this->totalTime;
    }

    public function getNumberOfCorrectAnswers(): int
    {
        return $this->numberOfCorrectAnswers;
    }

    public function getNumberOfWrongAnswers(): int
    {
        return $this->numberOfWrongAnswers;
    }

    public function getFinishedAt(): DateTimeImmutable
    {
        return $this->finishedAt;
    }
}
