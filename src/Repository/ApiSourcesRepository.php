<?php

namespace App\Repository;

use App\Entity\ApiSources;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ApiSources|null find($id, $lockMode = null, $lockVersion = null)
 * @method ApiSources|null findOneBy(array $criteria, array $orderBy = null)
 * @method ApiSources[]    findAll()
 * @method ApiSources[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApiSourcesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ApiSources::class);
    }

    public function findById($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.id = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->getQuery()
            ->getOneOrNullResult();
            ;
    }


    // /**
    //  * @return ApiSources[] Returns an array of ApiSources objects
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
    public function findOneBySomeField($value): ?ApiSources
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
