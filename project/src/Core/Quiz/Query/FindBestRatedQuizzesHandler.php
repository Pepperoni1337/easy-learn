<?php

declare(strict_types=1);

namespace App\Core\Quiz\Query;

use App\Core\Quiz\Model\Quiz;
use App\Core\Shared\Query\QueryHandler;
use App\Core\Shared\Traits\WithEntityManager;
use App\Util\StringUtil;

final class FindBestRatedQuizzesHandler implements QueryHandler
{
    use WithEntityManager;

    /**
     * @return Quiz[]
     */
    public function __invoke(
        FindBestRatedQuizzes $query,
    ): array {
        $limit = $query->limit;

        $dql = StringUtil::concat(
            'SELECT q ',
            'FROM ' . Quiz::class . ' q ',
            'WHERE q.' . Quiz::AVG_RATING . ' IS NOT NULL ',
            'ORDER BY q.' . Quiz::AVG_RATING . ' DESC ',
        );

        /** @var Quiz[] $result */
        $result = $this->entityManager->createQuery($dql)
            ->setMaxResults($limit)
            ->getResult();

        return $result;
    }
}
