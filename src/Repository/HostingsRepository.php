<?php

namespace App\Repository;

use App\Entity\Hostings;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Hostings>
 *
 * @method Hostings|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hostings|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hostings[]    findAll()
 * @method Hostings[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HostingsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Hostings::class);
    }

//    /**
//     * @return Hostings[] Returns an array of Hostings objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('h.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Hostings
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
