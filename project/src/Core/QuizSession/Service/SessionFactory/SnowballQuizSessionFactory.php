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
use App\Util\CollectionUtil;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

final class SnowballQuizSessionFactory implements QuizSessionFactory
{
    private array $leveQuestionCount = [3, 6, 9, 15, 24, 39];

    public function supports(GameStyle $style): bool
    {
        return $style === GameStyle::Snowball;
    }

    public function createNewSession(Quiz $quiz, User $user): QuizSession
    {
        $session = new QuizSession(
            quiz: $quiz,
            player: $user,
            status: QuizSessionStatus::IN_PROGRESS,
            settings: new QuizSessionSettings(
                keepWronglyAnsweredQuestions: true,
                randomOrder: false,
            ),
        );

        $levels = $this->createLevels($session);

        $session->setRemainingLevels($levels);

        return $session;
    }

    private function createLevels(QuizSession $session): Collection
    {
        $allQuestions = $session->getQuiz()->getQuestions();
        $result = new ArrayCollection();

        $levelNumber = 1;
        foreach ($this->leveQuestionCount as $count) {
            if ($allQuestions->count() > $count) {
                $level = new QuizSessionLevel(
                    quizSession: $session,
                    level: $levelNumber,
                );
                $level->setRemainingQuestions(CollectionUtil::sliceFromStart($allQuestions, $count));
                $levelNumber++;
            }
        }

        $level = new QuizSessionLevel(
            quizSession: $session,
            level: $levelNumber,
        );

        $level->setRemainingQuestions($allQuestions);

        $result->add($level);

        return $result;
    }
}
