<?php

namespace App\Repository;

use App\Entity\ArchiveVente;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ArchiveVente|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArchiveVente|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArchiveVente[]    findAll()
 * @method ArchiveVente[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArchiveVenteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArchiveVente::class);
    }

    // /**
    //  * @return ArchiveVente[] Returns an array of ArchiveVente objects
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
    public function findOneBySomeField($value): ?ArchiveVente
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
