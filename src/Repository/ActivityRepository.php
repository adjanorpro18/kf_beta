<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Activity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Activity|null find($id, $lockMode = null, $lockVersion = null)
 * @method Activity|null findOneBy(array $criteria, array $orderBy = null)
 * @method Activity[]    findAll()
 * @method Activity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActivityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Activity::class);
    }

    /**
     * Methode qui retourne les activités les plus recentes
     * @return Activity
     */

    public function TopTenRecentActivitiesPublished()
    {
        return $this->createQueryBuilder('a')
           ->addSelect('s')
           ->innerJoin('a.state', 's')
           ->andWhere('s.id = 2')
           ->orderBy('a.createdAt', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;

    }

    /**
     * Récupère les activités en lien avec une recherche
     * @param SearchData $search
     * @return Activity[]
     */
    public function findSearch(SearchData $search): array
    {
        $query = $this
            ->createQueryBuilder('a')
            ->select('c', 'a')
            ->join('a.category','c');

        //Recherche text

        if(!empty($search->q)){
            $query= $query
                ->andWhere('a.name LIKE :q')
                ->setParameter('q', "%{$search->q}%");
        }elseif(!empty($search->q)) {
            $query = $query
                ->andWhere('a.description LIKE :q')
                ->setParameter('q', "%{$search->q}%");

        }

        //Pour la date

        if(!empty($search->min)){
            $query = $query
                ->andWhere('a.createdAt >= :min')
                ->setParameter('min', $search->min);

        }
        //Recherche par catégorie

        if(!empty($search->categories)){
            $query = $query
                ->andWhere('c.id IN (:categories)')
                ->setParameter('categories', $search-> categories);
        }
        return $query->getQuery()->getResult();
    }


    // /**
    //  * @return Activity[] Returns an array of Activity objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Activity
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
