<?php

declare(strict_types=1);

namespace App\Core\QuizSession\Model;

enum GameStyle: string
{
    case Simple = 'simple';
    case Snowball = 'snowball';
}
