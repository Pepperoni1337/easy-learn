<?php

declare(strict_types=1);

namespace App\Core\QuizSession\Model;

enum QuestionStatus: string
{
    case NOT_ANSWERED = 'not_answered';
    case ANSWERED = 'answered';
}
