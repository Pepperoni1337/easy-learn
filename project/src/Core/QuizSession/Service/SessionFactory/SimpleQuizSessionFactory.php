<?php

declare(strict_types=1);

namespace App\Core\QuizSession\Service\SessionFactory;

use App\Core\Quiz\Model\Quiz;
use App\Core\QuizSession\Model\GameStyle;
use App\Core\QuizSession\Model\QuizSession;
use App\Core\QuizSession\Model\QuizSessionLevel;
use App\Core\QuizSession\Model\QuizSessionStatus;
use App\Core\User\Model\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

final class SimpleQuizSessionFactory implements QuizSessionFactory
{
    public const QUEStIONS_PER_LEVEL = 3;

    public function supports(GameStyle $style): bool
    {
        return $style === GameStyle::Simple;
    }

    public function createNewSession(Quiz $quiz, User $user): QuizSession
    {
        $session = new QuizSession(
            $quiz,
            $user,
            QuizSessionStatus::IN_PROGRESS,
        );

        $session->setRemainingLevels(
            $this->createLevels($session),
        );

        return $session;
    }

    private function createLevels(QuizSession $session): Collection
    {
        $allQuestions = $session->getQuiz()->getQuestions();
        $result = new ArrayCollection();

        $levelNumber = 1;

        $i = 0;
        $level = new QuizSessionLevel(
            quizSession: $session,
            level: $levelNumber,
        );

        foreach ($allQuestions as $question) {
            $level->addRemainingQuestion($question);
            if ($i % self::QUEStIONS_PER_LEVEL === self::QUEStIONS_PER_LEVEL - 1) {
                $result->add($level);
                $levelNumber++;
                $level = new QuizSessionLevel(
                    quizSession: $session,
                    level: $levelNumber,
                );
            }
            $i++;
        }

        $result->add($level);

        return $result;
    }
}
