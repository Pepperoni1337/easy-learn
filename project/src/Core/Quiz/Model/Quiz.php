<?php

declare(strict_types=1);

namespace App\Core\Quiz\Model;

use App\Core\Shared\Model\Entity;
use App\Core\Shared\Model\EntityTrait;
use App\Core\Shared\Model\Id;
use App\Core\User\Model\User;
use App\Util\RandomUtil;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Quiz implements Entity
{
    use EntityTrait;

    public const TITLE = 'title';
    public const DESCRIPTION = 'description';
    public const QUESTIONS = 'questions';
    public const SHARE_TOKEN = 'shareToken';
    public const CREATED_BY = 'createdBy';

    #[ORM\Column]
    private string $title;

    #[ORM\Column]
    private string $description;

    /**
     * @var Collection<int, QuizQuestion> $questions
     */
    #[ORM\OneToMany(targetEntity: QuizQuestion::class, mappedBy: QuizQuestion::QUIZ, cascade: ['persist'])]
    private Collection $questions;

    #[ORM\Column(unique: true)]
    private string $shareToken;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(onDelete: 'SET NULL')]
    private ?User $createdBy;

    public function __construct(
        string $title,
        string $description,
        User $createdBy,
    ) {
        $this->id = Id::new();
        $this->title = $title;
        $this->description = $description;
        $this->questions = new ArrayCollection();
        $this->shareToken = RandomUtil::generateShareToken($this->id->toString());
        $this->createdBy = $createdBy;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return Collection<int, QuizQuestion>
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(QuizQuestion $question): void
    {
        if (!$this->questions->contains($question)) {
            $this->questions->add($question);
        }
    }

    public function removeQuestion(QuizQuestion $question): void
    {
        if ($this->questions->contains($question)) {
            $this->questions->removeElement($question);
        }
    }

    public function getShareToken(): string
    {
        return $this->shareToken;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }
}
