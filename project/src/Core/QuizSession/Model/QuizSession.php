<?php

declare(strict_types=1);

namespace App\Core\QuizSession\Model;

use App\Core\Quiz\Model\Quiz;
use App\Core\Quiz\Model\QuizQuestion;
use App\Core\Shared\Model\Entity;
use App\Core\Shared\Model\EntityTrait;
use App\Core\Shared\Model\Id;
use App\Core\User\Model\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class QuizSession implements Entity
{
    use EntityTrait;

    public const QUIZ = 'quiz';
    public const OWNER = 'owner';
    public const STATUS = 'status';
    public const CURRENT_LEVEL = 'level';
    public const REMAINING_LEVELS = 'remainingLevels';

    #[ORM\ManyToOne(targetEntity: Quiz::class)]
    private Quiz $quiz;

    #[ORM\ManyToOne(targetEntity: User::class, cascade: ['persist'])]
    private User $owner;

    #[ORM\Column(enumType: QuizSessionStatus::class)]
    private QuizSessionStatus $status;

    #[ORM\OneToOne(targetEntity: QuizSessionLevel::class, cascade: ['persist'])]
    private ?QuizSessionLevel $currentLevel = null;

    #[ORM\OneToMany(targetEntity: QuizSessionLevel::class, mappedBy: QuizSessionLevel::QUIZ_SESSION, cascade: ['persist'])]
    private Collection $remainingLevels;

    public function __construct(
        Quiz $quiz,
        User $owner,
        QuizSessionStatus $status,
    ) {
        $this->id = Id::new();
        $this->quiz = $quiz;
        $this->owner = $owner;
        $this->status = $status;
        $this->remainingLevels = new ArrayCollection();
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

    public function getCurrentLevel(): QuizSessionLevel
    {
        return $this->currentLevel;
    }

    public function setCurrentLevel(QuizSessionLevel $currentLevel): void
    {
        $this->currentLevel = $currentLevel;
    }

    public function getRemainingLevels(): Collection
    {
        return $this->remainingLevels;
    }

    public function setRemainingLevels(Collection $remainingLevels): void
    {
        $this->remainingLevels = $remainingLevels;
    }

    public function addLevel(QuizSessionLevel $level): void
    {
        if (!$this->remainingLevels->contains($level)) {
            $this->remainingLevels->add($level);
        }
    }

    public function getCurrentQuestion(): QuizQuestion
    {
        return $this->currentLevel->getCurrentQuestion();
    }
}
