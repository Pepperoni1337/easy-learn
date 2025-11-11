<?php

declare(strict_types=1);

namespace App\Core\QuizSession\Query;

use App\Core\QuizSession\Model\QuizSessionResult;
use App\Core\Shared\Query\QueryHandler;
use App\Core\Shared\Traits\WithEntityManager;
use App\Util\StringUtil;

final class FindBestQuizSessionResultsHandler implements QueryHandler
{
    use WithEntityManager;

    /**
     * @return QuizSessionResult[]
     */
    public function __invoke(
        FindBestQuizSessionResults $query,
    ): array {
        $limit = $query->limit;

        $dql = StringUtil::concat(
            'SELECT qsr ',
            'FROM ' . QuizSessionResult::class . ' qsr ',
            'WHERE qsr.' . QuizSessionResult::Quiz . ' = :quiz ',
            'ORDER BY qsr.' . QuizSessionResult::TOTAL_SCORE . ' DESC ',
        );

        /** @var QuizSessionResult[] $result */
        $result = $this->entityManager->createQuery($dql)
            ->setParameter('quiz', $query->quiz->getId())
            ->setMaxResults($limit)
            ->getResult();

        return $result;
    }
}