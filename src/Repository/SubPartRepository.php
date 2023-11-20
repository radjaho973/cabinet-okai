<?php

namespace App\Repository;

use App\Entity\SubPart;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SubPart>
 *
 * @method SubPart|null find($id, $lockMode = null, $lockVersion = null)
 * @method SubPart|null findOneBy(array $criteria, array $orderBy = null)
 * @method SubPart[]    findAll()
 * @method SubPart[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubPartRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SubPart::class);
    }

//    /**
//     * @return SubPart[] Returns an array of SubPart objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SubPart
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
