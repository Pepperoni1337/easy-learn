<?php

declare(strict_types=1);

namespace App\Core\Quiz\Query;

use App\Core\Quiz\Model\Quiz;
use App\Core\QuizSession\Model\QuizSession;
use App\Core\Shared\Query\QueryHandler;
use App\Core\Shared\Traits\WithEntityManager;
use App\Util\StringUtil;

final class FindMostPlayedQuizzesHandler implements QueryHandler
{
    use WithEntityManager;

    /**
     * @return Quiz[]
     */
    public function __invoke(
        FindMostPlayedQuizzes $query,
    ): array {
        $limit = $query->limit;

        $dql = StringUtil::concat(
            'SELECT q, COUNT(qs.id) as sessionCount ',
            'FROM ' . Quiz::class . ' q ',
            'JOIN ' . QuizSession::class . ' qs WITH qs.' . QuizSession::QUIZ . ' = q ',
            'GROUP BY q.id ',
            'ORDER BY sessionCount DESC ',
        );

        /** @var Quiz[] $result */
        $result = $this->entityManager->createQuery($dql)
            ->setMaxResults($limit)
            ->getResult();

        // Extract only the Quiz objects from the result
        return array_map(
            static fn (array $item) => $item[0],
            $result
        );
    }
}
