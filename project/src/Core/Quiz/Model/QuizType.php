<?php

declare(strict_types=1);

namespace App\Core\Quiz\Model;

enum QuizType: string
{
    case Multilevel = 'multilevel';
    case MultilevelWithRepetition = 'multilevel_with_repetition';
    case SingleLevel = 'single_level';
}