<?php

declare(strict_types=1);

namespace App\Core\Quiz\Model;

use App\Core\Shared\Model\Entity;
use App\Core\Shared\Model\EntityTrait;
use App\Core\Shared\Model\Id;
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

    public function __construct()
    {
        $this->id = Id::new();
        $this->questions = new ArrayCollection();
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

    public function getRandomQuestion(Collection $answeredQuestion): ?QuizQuestion
    {
        $remainingQuestions = $this->questions->filter(
            function (QuizQuestion $question) use ($answeredQuestion) {
                return !$answeredQuestion->contains($question);
            }
        );

        // If there are no remaining questions, return null
        if ($remainingQuestions->isEmpty()) {
            return null;
        }

        // Get a random index within the range of remaining questions
        $randomIndex = rand(0, $remainingQuestions->count() - 1);

        // Return the question at the random index
        $result =  $remainingQuestions->slice($randomIndex, 1);

        foreach ($result as $question) {
            return $question;
        }
    }
}
