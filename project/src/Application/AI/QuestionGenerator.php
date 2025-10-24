<?php

namespace App\Application\AI;

interface QuestionGenerator
{
    /**
     * @return array<int, QuestionDto>
     */
    public function generateQuestions(): array;
}