<?php

declare(strict_types=1);

namespace App\Core\QuizSession\Model;

use App\Core\Shared\Model\Entity;
use App\Core\Shared\Model\EntityTrait;
use App\Core\Shared\Model\Id;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
class QuizSessionLevelQuestion implements Entity
{
    use EntityTrait;

    public const LEVEL = 'level';
    public const QUESTION = 'question';
    public const ANSWER = 'answer';
    public const WRONG_ANSWER_1 = 'wrongAnswer1';
    public const WRONG_ANSWER_2 = 'wrongAnswer2';
    public const WRONG_ANSWER_3 = 'wrongAnswer3';
    public const STATUS = 'status';

    #[ORM\ManyToOne(targetEntity: QuizSessionLevel::class, cascade: ['persist', 'remove'])]
    #[Assert\NotBlank]
    private QuizSessionLevel $level;

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

    #[ORM\Column(type: Types::STRING, enumType: QuestionStatus::class, options: ['default' => QuestionStatus::NOT_ANSWERED])]
    private QuestionStatus $status;

    public function __construct(
        QuizSessionLevel $level,
        string $question,
        string $answer,
        string $wrongAnswer1,
        string $wrongAnswer2,
        string $wrongAnswer3,
    ) {
        $this->id = Id::new();
        $this->level = $level;
        $this->question = $question;
        $this->answer = $answer;
        $this->wrongAnswer1 = $wrongAnswer1;
        $this->wrongAnswer2 = $wrongAnswer2;
        $this->wrongAnswer3 = $wrongAnswer3;
        $this->status = QuestionStatus::NOT_ANSWERED;
    }

    public function getLevel(): QuizSessionLevel
    {
        return $this->level;
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

    public function getStatus(): QuestionStatus
    {
        return $this->status;
    }

    public function setStatus(QuestionStatus $status): void
    {
        $this->status = $status;
    }

    public function __toString(): string
    {
        return $this->question;
    }
}
