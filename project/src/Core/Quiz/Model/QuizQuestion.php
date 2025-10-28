<?php

declare(strict_types=1);

namespace App\Core\Quiz\Model;

use App\Core\Shared\Model\Entity;
use App\Core\Shared\Model\EntityTrait;
use App\Core\Shared\Model\Id;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
class QuizQuestion implements Entity
{
    use EntityTrait;

    public const QUIZ = 'quiz';
    public const QUESTION = 'question';
    public const ANSWER = 'answer';
    public const WRONG_ANSWER_1 = 'wrongAnswer1';
    public const WRONG_ANSWER_2 = 'wrongAnswer2';
    public const WRONG_ANSWER_3 = 'wrongAnswer3';

    #[ORM\ManyToOne(targetEntity: Quiz::class, cascade: ['persist', 'remove'])]
    #[Assert\NotBlank]
    private Quiz $quiz;

    #[ORM\Column]
    #[Assert\NotBlank]
    private string $question;

    #[ORM\Column]
    #[Assert\NotBlank]
    private string $answer;

    #[ORM\Column(nullable: true)]
    #[Assert\NotBlank(allowNull: true)]
    private ?string $wrongAnswer1 = null;

    #[ORM\Column(nullable: true)]
    #[Assert\NotBlank(allowNull: true)]
    private ?string $wrongAnswer2 = null;

    #[ORM\Column(nullable: true)]
    #[Assert\NotBlank(allowNull: true)]
    private ?string $wrongAnswer3 = null;

    public function __construct(
      Quiz $quiz,
      string $question,
      string $answer,
    ) {
        $this->id = Id::new();
        $this->quiz = $quiz;
        $this->question = $question;
        $this->answer = $answer;
    }

    public function getQuiz(): Quiz
    {
        return $this->quiz;
    }

    public function setQuiz(Quiz $quiz): void
    {
        $this->quiz = $quiz;
    }

    public function getQuestion(): string
    {
        return $this->question;
    }

    public function setQuestion(string $question): void
    {
        $this->question = $question;
    }

    public function getAnswer(): string
    {
        return $this->answer;
    }

    public function setAnswer(string $answer): void
    {
        $this->answer = $answer;
    }

    public function __toString(): string
    {
        return $this->question;
    }
}
