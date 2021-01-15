<?php

namespace App\Repository;

use App\Entity\Publics;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Publics|null find($id, $lockMode = null, $lockVersion = null)
 * @method Publics|null findOneBy(array $criteria, array $orderBy = null)
 * @method Publics[]    findAll()
 * @method Publics[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PublicsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Publics::class);
    }

    // /**
    //  * @return Publics[] Returns an array of Publics objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Publics
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
