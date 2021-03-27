<?php

namespace App\Repository;

use App\Entity\RealEstates;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RealEstates|null find($id, $lockMode = null, $lockVersion = null)
 * @method RealEstates|null findOneBy(array $criteria, array $orderBy = null)
 * @method RealEstates[]    findAll()
 * @method RealEstates[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RealEstatesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RealEstates::class);
    }

}
