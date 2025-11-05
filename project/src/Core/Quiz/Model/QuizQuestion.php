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

    #[ORM\ManyToOne(targetEntity: Quiz::class, cascade: ['persist', 'remove'], inversedBy: Quiz::QUESTIONS)]
    #[Assert\NotBlank]
    private Quiz $quiz;

    #[ORM\Column]
    #[Assert\NotBlank]
    private string $question;

    #[ORM\Column]
    #[Assert\NotBlank]
    private string $answer;

    #[ORM\Column]
    #[Assert\NotBlank]
    private string $wrongAnswer1;

    #[ORM\Column]
    #[Assert\NotBlank]
    private string $wrongAnswer2;

    #[ORM\Column]
    #[Assert\NotBlank]
    private string $wrongAnswer3;

    public function __construct(
        Quiz $quiz,
        string $question,
        string $answer,
        string $wrongAnswer1,
        string $wrongAnswer2,
        string $wrongAnswer3,
    ) {
        $this->id = Id::new();
        $this->quiz = $quiz;
        $this->question = $question;
        $this->answer = $answer;
        $this->wrongAnswer1 = $wrongAnswer1;
        $this->wrongAnswer2 = $wrongAnswer2;
        $this->wrongAnswer3 = $wrongAnswer3;
    }

    public function getQuiz(): Quiz
    {
        return $this->quiz;
    }

    public function getQuestion(): string
    {
        return $this->question;
    }

    public function getAnswer(): string
    {
        return $this->answer;
    }

    public function getWrongAnswer1(): ?string
    {
        return $this->wrongAnswer1;
    }

    public function getWrongAnswer2(): ?string
    {
        return $this->wrongAnswer2;
    }

    public function getWrongAnswer3(): ?string
    {
        return $this->wrongAnswer3;
    }

    public function __toString(): string
    {
        return $this->question;
    }
}
