<?php

namespace App\Repository;

use App\Entity\RemunerationType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RemunerationType|null find($id, $lockMode = null, $lockVersion = null)
 * @method RemunerationType|null findOneBy(array $criteria, array $orderBy = null)
 * @method RemunerationType[]    findAll()
 * @method RemunerationType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RemunerationTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RemunerationType::class);
    }

    // /**
    //  * @return RemunerationType[] Returns an array of RemunerationType objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RemunerationType
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
