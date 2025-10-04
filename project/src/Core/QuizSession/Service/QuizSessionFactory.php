<?php

declare(strict_types=1);

namespace App\Core\QuizSession\Service;

use App\Core\Quiz\Model\Quiz;
use App\Core\QuizSession\Model\QuizSession;
use App\Core\QuizSession\Model\QuizSessionStatus;
use App\Core\User\Model\User;
use App\Util\CollectionUtil;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

final class QuizSessionFactory
{
    private array $leveQuestionCount = [3, 6, 9, 15, 24, 39];

    public function __construct(
        private readonly QuizSessionLevelFactory $levelFactory,
    ) {
    }

    public function createNewSession(Quiz $quiz, User $user): QuizSession
    {
        $session = new QuizSession(
            $quiz,
            $user,
            QuizSessionStatus::IN_PROGRESS,
        );

        $levels = $this->createLevels($session);

        $session->setRemainingLevels($levels);
        $session->setCurrentLevel($levels->first());

        return $session;
    }

    private function createLevels(QuizSession $session): Collection {
        $allQuestions = $session->getQuiz()->getQuestions();
        $result = new ArrayCollection();

        foreach ($this->leveQuestionCount as $count) {
            if ($allQuestions->count() < $count) {
                $result->add(
                    $this->levelFactory->createLevel(
                        session: $session,
                        levelNumber: 1,
                        questions: CollectionUtil::firstElements($allQuestions, $count),
                    )
                );
            }
        }

        $result->add(
            $this->levelFactory->createLevel(
                session: $session,
                levelNumber: 1,
                questions: $allQuestions,
            )
        );

        return $result;
    }
}