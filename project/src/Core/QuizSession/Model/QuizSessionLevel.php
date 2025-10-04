<?php

declare(strict_types=1);

namespace App\Core\QuizSession\Model;

use App\Core\Quiz\Model\QuizQuestion;
use App\Core\Shared\Model\Entity;
use App\Core\Shared\Model\EntityTrait;
use App\Core\Shared\Model\Id;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class QuizSessionLevel implements Entity
{
    use EntityTrait;

    public const QUIZ_SESSION = 'quiz_session';
    public const LEVEL = 'level';
    public const STATUS = 'status';
    public const CURRENT_QUESTION = 'currentQuestion';
    public const REMAINING_QUESTIONS = 'remainingQuestions';

    #[ORM\ManyToOne(targetEntity: QuizSession::class, inversedBy: QuizSession::CURRENT_LEVEL)]
    private QuizSession $quizSession;

    #[ORM\Column(type: Types::INTEGER)]
    private int $level;

    #[ORM\Column(enumType: QuizSessionLevelStatus::class)]
    private QuizSessionLevelStatus $status;

    #[ORM\ManyToOne(targetEntity: QuizQuestion::class)]
    private QuizQuestion $currentQuestion;

    /**
     * @var Collection<QuizQuestion> $remainingQuestions
     */
    #[ORM\ManyToMany(targetEntity: QuizQuestion::class)]
    private Collection $remainingQuestions;

    public function __construct(
        QuizSession $quizSession,
        int $level,
        QuizSessionLevelStatus $status,
        Collection $remainingQuestions,
    ) {
        $this->id = Id::new();
        $this->quizSession = $quizSession;
        $this->level = $level;
        $this->status = $status;
        $this->currentQuestion = $remainingQuestions->first();
        $this->remainingQuestions = $remainingQuestions;
    }

    public function getQuizSession(): QuizSession
    {
        return $this->quizSession;
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    public function getStatus(): QuizSessionLevelStatus
    {
        return $this->status;
    }

    public function setStatus(QuizSessionLevelStatus $status): void
    {
        $this->status = $status;
    }

    public function getCurrentQuestion(): QuizQuestion
    {
        return $this->currentQuestion;
    }

    public function setCurrentQuestion(QuizQuestion $currentQuestion): void
    {
        $this->currentQuestion = $currentQuestion;
    }

    public function getRemainingQuestions(): Collection
    {
        return $this->remainingQuestions;
    }

    public function removeQuestion(QuizQuestion $question): void
    {
        if ($this->remainingQuestions->contains($question)) {
            $this->remainingQuestions->removeElement($question);
        }
    }
}