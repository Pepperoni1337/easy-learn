<?php

declare(strict_types=1);

namespace App\UI\Http\Quiz;

use App\Core\Quiz\Model\Difficulty;

final class QuizDto
{
    public function __construct(
        public string $name = '',
        public string $prompt = '',
        public QuizSize $size = QuizSize::Medium,
        public Difficulty $difficulty = Difficulty::Medium,
    ) {
    }
}
