<?php

declare(strict_types=1);

namespace App\Core\Quiz\Model;

use App\Core\QuizSession\Model\QuizSessionSettings;
use App\Core\Shared\Model\Entity;
use App\Core\Shared\Model\EntityTrait;
use App\Core\Shared\Model\Id;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class QuizInvitation implements Entity
{
    use EntityTrait;

    public const HASH = 'hash';
    public const QUIZ = 'quiz';
    public const SETTINGS = 'settings';

    private string $hash;

    private Quiz $quiz;

    private QuizSessionSettings $settings;

    public function __construct(
        Quiz $quiz,
        QuizSessionSettings $settings,
    ) {
        $this->id = Id::new();
        $this->quiz = $quiz;
        $this->settings = $settings;
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    public function getQuiz(): Quiz
    {
        return $this->quiz;
    }

    public function setQuiz(Quiz $quiz): void
    {
        $this->quiz = $quiz;
    }

    public function getSettings(): QuizSessionSettings
    {
        return $this->settings;
    }

    public function setSettings(QuizSessionSettings $settings): void
    {
        $this->settings = $settings;
    }
}
