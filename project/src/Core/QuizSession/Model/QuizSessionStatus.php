<?php

declare(strict_types=1);

namespace App\Core\QuizSession\Model;

enum QuizSessionStatus: string
{
    case IN_PROGRESS = 'in_progress';
    case FINISHED = 'finished';
}
