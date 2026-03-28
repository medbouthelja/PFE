<?php

namespace App\Repository;

use App\Entity\FinOpsRecommendation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FinOpsRecommendation>
 */
class FinOpsRecommendationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FinOpsRecommendation::class);
    }
}
