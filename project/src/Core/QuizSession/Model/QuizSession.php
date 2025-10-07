<?php

declare(strict_types=1);

namespace App\Core\QuizSession\Model;

use App\Core\Quiz\Model\Quiz;
use App\Core\Quiz\Model\QuizQuestion;
use App\Core\Shared\Model\Entity;
use App\Core\Shared\Model\EntityTrait;
use App\Core\Shared\Model\Id;
use App\Core\User\Model\User;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
class QuizSession implements Entity
{
    use EntityTrait;

    public const QUIZ = 'quiz';
    public const OWNER = 'owner';
    public const STATUS = 'status';
    public const REMAINING_LEVELS = 'remainingLevels';
    public const SCORE = 'score';
    public const CREATED_AT = 'createdAt';
    public const UPDATED_AT = 'updatedAt';

    #[ORM\ManyToOne(targetEntity: Quiz::class)]
    private Quiz $quiz;

    #[ORM\ManyToOne(targetEntity: User::class, cascade: ['persist'])]
    private User $owner;

    #[ORM\Column(enumType: QuizSessionStatus::class)]
    private QuizSessionStatus $status;

    #[ORM\OneToMany(targetEntity: QuizSessionLevel::class, mappedBy: QuizSessionLevel::QUIZ_SESSION, cascade: ['persist'], orphanRemoval: true)]
    private Collection $remainingLevels;

    #[ORM\Column(type: Types::INTEGER, options: ['default' => 0])]
    private int $score = 0;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $updatedAt;

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
        $this->createdAt = new DateTimeImmutable();
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

    public function getCurrentLevel(): ?QuizSessionLevel
    {
        if ($this->remainingLevels->isEmpty()) {
            return null;
        }

        return $this->remainingLevels->first();
    }

    public function setRemainingLevels(Collection $remainingLevels): void
    {
        $this->remainingLevels = $remainingLevels;
    }

    public function removeRemainingLevel(QuizSessionLevel $level): void
    {
        if ($this->remainingLevels->contains($level)) {
            $this->remainingLevels->removeElement($level);
        }
    }

    public function getCurrentQuestion(): ?QuizQuestion
    {
        return $this->getCurrentLevel()?->getCurrentQuestion();
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function addScore(int $points): void
    {
        $this->score += $points;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    #[ORM\PreUpdate]
    #[ORM\PrePersist]
    public function updateTimestamp(): void
    {
        $this->updatedAt = new DateTimeImmutable();
    }
}
