<?php

namespace App\Repository;

use App\Entity\TypeActivity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TypeActivity|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeActivity|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeActivity[]    findAll()
 * @method TypeActivity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeActivityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeActivity::class);
    }

    // /**
    //  * @return TypeActivity[] Returns an array of TypeActivity objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TypeActivity
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
