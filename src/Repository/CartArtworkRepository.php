<?php

namespace App\Repository;

use App\Entity\CartArtwork;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CartArtwork>
 *
 * @method CartArtwork|null find($id, $lockMode = null, $lockVersion = null)
 * @method CartArtwork|null findOneBy(array $criteria, array $orderBy = null)
 * @method CartArtwork[]    findAll()
 * @method CartArtwork[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CartArtworkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CartArtwork::class);
    }

    //    /**
    //     * @return CartArtwork[] Returns an array of CartArtwork objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?CartArtwork
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
