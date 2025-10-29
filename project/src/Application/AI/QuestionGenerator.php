<?php

namespace App\Application\AI;

interface QuestionGenerator
{
    /**
     * @return array<int, QuestionDto>
     */
    public function generateQuestions(string $prompt, int $minCount, int $maxCount): array;
}
