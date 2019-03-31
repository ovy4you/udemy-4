<?php

namespace App\Repository;

use App\Entity\MicroPostEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method MicroPostEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method MicroPostEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method MicroPostEntity[]    findAll()
 * @method MicroPostEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MicroPostEntityRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MicroPostEntity::class);
    }

    // /**
    //  * @return MicroPostEntity[] Returns an array of MicroPostEntity objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MicroPostEntity
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
