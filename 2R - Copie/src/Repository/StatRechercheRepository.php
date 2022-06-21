<?php

namespace App\Repository;

use App\Entity\StatRecherche;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StatRecherche|null find($id, $lockMode = null, $lockVersion = null)
 * @method StatRecherche|null findOneBy(array $criteria, array $orderBy = null)
 * @method StatRecherche[]    findAll()
 * @method StatRecherche[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StatRechercheRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StatRecherche::class);
    }

    // /**
    //  * @return StatRecherche[] Returns an array of StatRecherche objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?StatRecherche
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
