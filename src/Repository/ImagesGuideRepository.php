<?php

namespace App\Repository;

use App\Entity\ImagesGuide;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ImagesGuide>
 *
 * @method ImagesGuide|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImagesGuide|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImagesGuide[]    findAll()
 * @method ImagesGuide[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImagesGuideRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImagesGuide::class);
    }

//    /**
//     * @return ImagesGuide[] Returns an array of ImagesGuide objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ImagesGuide
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
