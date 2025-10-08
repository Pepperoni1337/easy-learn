<?php

declare(strict_types=1);

namespace App\Core\Quiz\Model;

use App\Core\Shared\Model\Entity;
use App\Core\Shared\Model\EntityTrait;
use App\Core\Shared\Model\Id;
use App\Util\RandomUtil;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
class Quiz implements Entity
{
    use EntityTrait;

    public const TITLE = 'title';
    public const DESCRIPTION = 'description';
    public const QUESTIONS = 'questions';
    public const SHARE_TOKEN = 'shareToken';

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Please enter a title')]
    private ?string $title;

    #[ORM\Column]
    #[Assert\NotBlank]
    private ?string $description;

    /**
     * @var Collection<QuizQuestion> $questions
     */
    #[ORM\OneToMany(targetEntity: QuizQuestion::class, mappedBy: QuizQuestion::QUIZ, cascade: ['persist'])]
    private Collection $questions;

    #[ORM\Column(unique: true)]
    private string $shareToken;

    public function __construct()
    {
        $this->id = Id::new();
        $this->questions = new ArrayCollection();
        $this->shareToken = RandomUtil::generateShareToken($this->id->toString());
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

    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(QuizQuestion $question): void
    {
        if (!$this->questions->contains($question)) {
            $this->questions->add($question);
            $question->setQuiz($this);
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
}
