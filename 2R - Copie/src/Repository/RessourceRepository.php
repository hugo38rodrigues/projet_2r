<?php

namespace App\Repository;

use App\Entity\Ressource;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\Array_;

/**
 * @method Ressource|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ressource|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ressource[]    findAll()
 * @method Ressource[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RessourceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ressource::class);
    }

    public function search(array $fichiers){
        $ids=null;
        foreach ($fichiers as $fichier){
            $ids[]=$fichier['id'];
        }
        $em = $this->getEntityManager();
        $query = $em->createQuery('select d from App\Entity\ressource d where d.id in (:file)');
        $query->setParameter('file',$ids);
        return $query->getResult();
    }

    public function findByFiltre(Ressource $ressource){

        $query = $this->createQueryBuilder('d');

        if ($ressource->getCategorie() != null){

            $query = $query
                ->andwhere('d.categorie = (:cat)')
                ->setParameter('cat', $ressource->getCategorie());
        }
        if ($ressource->getExploite() != null){

            $query = $query
                ->andwhere('d.exploite = (:cat)')
                ->setParameter('cat', $ressource->getExploite());
        }
        if ($ressource->getDemarre() != null){

            $query = $query
                ->andwhere('d.demarre = (:cat)')
                ->setParameter('cat', $ressource->getDemarre());
        }
        if ($ressource->getAcces() != null){

            $query = $query
                ->andwhere('d.acces = (:cat)')
                ->setParameter('cat', $ressource->getAcces());
        }

        $query = $query->getQuery();
        return $query->getResult();

    }

    // /**
    //  * @return Ressource[] Returns an array of Ressource objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Ressource
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
