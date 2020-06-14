<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\UrlStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UrlStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method UrlStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method UrlStatus[]    findAll()
 * @method UrlStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UrlStatusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UrlStatus::class);
    }

    // /**
    //  * @return UrlStatus[] Returns an array of UrlStatus objects
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
    public function findOneBySomeField($value): ?UrlStatus
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
