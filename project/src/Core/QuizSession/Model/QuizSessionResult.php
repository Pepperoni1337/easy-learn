<?php

declare(strict_types=1);

namespace App\Core\QuizSession\Model;

use App\Core\Quiz\Model\Quiz;
use App\Core\Shared\Model\Entity;
use App\Core\Shared\Model\EntityTrait;
use App\Core\Shared\Model\Id;
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

    private float $totalTime;

    private int $numberOfCorrectAnswers;

    private int $numberOfWrongAnswers;

    public function __construct(
        Quiz $quiz,
        QuizSession $session,
        int $totalScore,
        float $totalTime,
        int $numberOfCorrectAnswers,
        int $numberOfWrongAnswers,
    ) {
        $this->id = Id::new();
        $this->session = $session;
        $this->totalScore = $totalScore;
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
}
