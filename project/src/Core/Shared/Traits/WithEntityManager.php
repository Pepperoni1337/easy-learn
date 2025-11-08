<?php

namespace App\Core\Shared\Traits;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Contracts\Service\Attribute\Required;

trait WithEntityManager
{
    private EntityManagerInterface $entityManager;

    #[Required]
    public function setEntityManager(
        EntityManagerInterface $entityManager,
    ): void {
        $this->entityManager = $entityManager;
    }

    protected function getRepository(string $className): EntityRepository
    {
        return $this->entityManager->getRepository($className);
    }
}
