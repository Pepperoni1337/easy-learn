<?php

declare(strict_types=1);

namespace App\Core\QuizSession\Service;

use App\Core\QuizSession\Model\QuizSession;
use App\Core\QuizSession\Model\QuizSessionLevel;
use Doctrine\Common\Collections\Collection;

final class QuizSessionLevelFactory
{
    public function createLevel(
        QuizSession $session,
        int $levelNumber,
        Collection $questions,
    ): QuizSessionLevel {
        return new QuizSessionLevel(
            $session,
            $levelNumber,
            $questions,
        );
    }
}
