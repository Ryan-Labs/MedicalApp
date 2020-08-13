<?php

namespace App\Repository;

use App\Entity\UserAttribute;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserAttribute|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserAttribute|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserAttribute[]    findAll()
 * @method UserAttribute[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserAttributeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserAttribute::class);
    }

    // /**
    //  * @return UserAttribute[] Returns an array of UserAttribute objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserAttribute
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
