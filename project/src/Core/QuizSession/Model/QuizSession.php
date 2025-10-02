<?php

declare(strict_types=1);

namespace App\Core\QuizSession\Model;

use App\Core\Quiz\Model\Quiz;
use App\Core\Quiz\Model\QuizQuestion;
use App\Core\Shared\Model\Entity;
use App\Core\Shared\Model\EntityTrait;
use App\Core\Shared\Model\Id;
use App\Core\User\Model\User;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class QuizSession implements Entity
{
    use EntityTrait;

    public const QUIZ = 'quiz';
    public const OWNER = 'owner';
    public const STATUS = 'status';
    public const CURRENT_QUESTION = 'currentQuestion';
    public const REMAINING_QUESTIONS = 'remainingQuestions';

    #[ORM\ManyToOne(targetEntity: Quiz::class)]
    private Quiz $quiz;

    #[ORM\ManyToOne(targetEntity: User::class, cascade: ['persist'])]
    private User $owner;

    #[ORM\Column(enumType: QuizSessionStatus::class)]
    private QuizSessionStatus $status;

    #[ORM\ManyToOne(targetEntity: QuizQuestion::class)]
    private QuizQuestion $currentQuestion;

    /**
     * @var Collection<QuizQuestion> $remainingQuestions
     */
    #[ORM\ManyToMany(targetEntity: QuizQuestion::class)]
    private Collection $remainingQuestions;

    public function __construct(
        Quiz $quiz,
        User $owner,
    ) {
        $this->id = Id::new();
        $this->quiz = $quiz;
        $this->owner = $owner;
        $this->status = QuizSessionStatus::IN_PROGRESS;
        $remainingQuestions = $quiz->getQuestions();
        $this->remainingQuestions = $remainingQuestions;
        $this->currentQuestion = $this->getRandomRemainingQuestion();
    }

    public function getQuiz(): Quiz
    {
        return $this->quiz;
    }

    public function setQuiz(Quiz $quiz): void
    {
        $this->quiz = $quiz;
    }

    public function getOwner(): User
    {
        return $this->owner;
    }

    public function setOwner(User $owner): void
    {
        $this->owner = $owner;
    }

    public function getStatus(): QuizSessionStatus
    {
        return $this->status;
    }

    public function setStatus(QuizSessionStatus $status): void
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

    /**
     * @return Collection<QuizQuestion>
     */
    public function getRemainingQuestions(): Collection
    {
        return $this->remainingQuestions;
    }

    /**
     * @param Collection<QuizQuestion> $remainingQuestions
     */
    public function setRemainingQuestions(Collection $remainingQuestions): void
    {
        $this->remainingQuestions = $remainingQuestions;
    }

    public function removeRemainingQuestion(QuizQuestion $question): void
    {
        if ($this->remainingQuestions->contains($question)) {
            $this->remainingQuestions->removeElement($question);
        }
    }

    public function getRandomRemainingQuestion(): ?QuizQuestion
    {
        if ($this->remainingQuestions->isEmpty()) {
            return null;
        }

        $keys = $this->remainingQuestions->getKeys();
        $randomKey = $keys[array_rand($keys)];

        return $this->remainingQuestions->get($randomKey);
    }
}
