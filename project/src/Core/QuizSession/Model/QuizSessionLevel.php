<?php

declare(strict_types=1);

namespace App\Core\QuizSession\Model;

use App\Core\Quiz\Model\QuizQuestion;
use App\Core\Shared\Model\Entity;
use App\Core\Shared\Model\EntityTrait;
use App\Core\Shared\Model\Id;
use App\Util\CollectionUtil;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class QuizSessionLevel implements Entity
{
    use EntityTrait;

    public const QUIZ_SESSION = 'quizSession';
    public const LEVEL = 'level';
    public const REMAINING_QUESTIONS = 'remainingQuestions';
    public const NUMBER_OF_QUESTIONS_AT_START = 'numberOfQuestionsAtStart';

    #[ORM\ManyToOne(targetEntity: QuizSession::class, inversedBy: QuizSession::REMAINING_LEVELS)]
    #[ORM\JoinColumn(onDelete: 'CASCADE')]
    private QuizSession $quizSession;

    #[ORM\Column(type: Types::INTEGER)]
    private int $level;

    /**
     * @var Collection<QuizSessionLevelQuestion> $questions
     */
    #[ORM\OneToMany(targetEntity: QuizSessionLevelQuestion::class, mappedBy: QuizSessionLevelQuestion::LEVEL, cascade: ['persist', 'remove'])]
    private Collection $questions;

    public function __construct(
        QuizSession $quizSession,
        int $level,
    ) {
        $this->id = Id::new();
        $this->quizSession = $quizSession;
        $this->level = $level;
        $this->questions = new ArrayCollection();
    }

    public function getQuizSession(): QuizSession
    {
        return $this->quizSession;
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    public function getCurrentQuestion(): ?QuizSessionLevelQuestion
    {
        return CollectionUtil::getRandomElement($this->getRemainingQuestions());
    }

    public function isFinished(): bool
    {
        return $this->getRemainingQuestions()->isEmpty();
    }

    public function setQuestions(Collection $questions): void
    {
        $this->questions = $questions;
    }

    public function hasRemainingQuestions(): bool
    {
        return !$this->getRemainingQuestions()->isEmpty();
    }

    public function getRemainingQuestions(): Collection
    {
        return $this->questions->filter(
            fn (QuizSessionLevelQuestion $question) => $question->getStatus() === QuestionStatus::NOT_ANSWERED
        );
    }

    public function getNumberOfQuestionsAtStart(): int
    {
        return $this->questions->count();
    }

    public function addQuestion($question): void
    {
        if (!$this->questions->contains($question)) {
            $this->questions->add($question);
        }
    }
}
