<?php

declare(strict_types=1);

namespace App\Core\QuizSession\Service\SessionFactory;

use App\Core\Quiz\Model\Quiz;
use App\Core\QuizSession\Model\GameStyle;
use App\Core\QuizSession\Model\QuizSession;
use App\Core\QuizSession\Model\QuizSessionLevel;
use App\Core\QuizSession\Model\QuizSessionSettings;
use App\Core\QuizSession\Model\QuizSessionStatus;
use App\Core\User\Model\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

final class SimpleQuizSessionFactory implements QuizSessionFactory
{
    public const QUESTIONS_PER_LEVEL = 3;

    public function supports(GameStyle $style): bool
    {
        return $style === GameStyle::Simple;
    }

    public function createNewSession(Quiz $quiz, User $user): QuizSession
    {
        $session = new QuizSession(
            quiz: $quiz,
            player: $user,
            status: QuizSessionStatus::IN_PROGRESS,
            settings: new QuizSessionSettings(
                keepWronglyAnsweredQuestions: false,
                randomOrder: false,
            ),
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

        $level = new QuizSessionLevel(
            quizSession: $session,
            level: 1,
        );

        foreach ($allQuestions as $question) {
            $level->addRemainingQuestion($question);
        }

        $result->add($level);

        return $result;
    }
}
