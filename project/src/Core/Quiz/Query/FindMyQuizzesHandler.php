<?php

declare(strict_types=1);

namespace App\Core\Quiz\Query;

use App\Core\Quiz\Model\Quiz;
use App\Core\Shared\Query\QueryHandler;
use App\Core\Shared\Traits\WithEntityManager;
use App\Util\StringUtil;

final class FindMyQuizzesHandler implements QueryHandler
{
    use WithEntityManager;

    /**
     * @return Quiz[]
     */
    public function __invoke(
        FindMyQuizzes $query,
    ): array {
        $user = $query->user;
        $limit = $query->limit;

        $dql = StringUtil::concat(
            'SELECT q ',
            'FROM ' . Quiz::class . ' q ',
            'WHERE q.createdBy = :user ',
            'ORDER BY q.createdAt DESC ',
        );

        /** @var Quiz[] $result */
        $result = $this->entityManager->createQuery($dql)
            ->setParameter('user', $user->getId())
            ->setMaxResults($limit)
            ->getResult();

        return $result;
    }
}