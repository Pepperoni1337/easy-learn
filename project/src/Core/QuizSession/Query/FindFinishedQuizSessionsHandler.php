<?php

declare(strict_types=1);

namespace App\Core\QuizSession\Query;

use App\Core\QuizSession\Model\QuizSession;
use App\Core\QuizSession\Model\QuizSessionStatus;
use App\Core\Shared\Query\QueryHandler;
use App\Core\Shared\Traits\WithEntityManager;
use App\Util\StringUtil;

final class FindFinishedQuizSessionsHandler implements QueryHandler
{
    use WithEntityManager;

    /**
     * @return QuizSession[]
     */
    public function __invoke(
        FindFinishedQuizSessions $query,
    ): array {
        $limit = $query->limit;

        $dql = StringUtil::concat(
            'SELECT qs ',
            'FROM ' . QuizSession::class . ' qs ',
            'WHERE qs.' . QuizSession::STATUS . ' = :status ',
            'ORDER BY qs.' . QuizSession::CREATED_AT . ' DESC ',
        );

        /** @var QuizSession[] $result */
        $result = $this->entityManager->createQuery($dql)
            ->setParameter('status', QuizSessionStatus::FINISHED)
            ->setMaxResults($limit)
            ->getResult();

        return $result;
    }
}
