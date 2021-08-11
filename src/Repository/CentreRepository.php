<?php

namespace App\Repository;

use App\Classe\Search;
use App\Entity\Centre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Centre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Centre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Centre[]    findAll()
 * @method Centre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CentreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Centre::class);
    }


    /**
     * Requête qui me permet de récuperer les articles en fonction de la recherche de l'utilisateur
     * @return Centre[]
     */
    public function findWithSearch(Search $search)
    {
        $query = $this
            ->createQueryBuilder('c')
            ->select('p', 'c')
            ->join('c.province', 'p');

        if (!empty($search->q)) {
            $query = $query
                ->andWhere('c.nom LIKE :string')
                ->orWhere('c.ville LIKE :string')
                ->orWhere('c.rue LIKE :string')
                ->orWhere('c.cp LIKE :string')
                ->setParameter('string', "%{$search->q}%");
        }

        if (!empty($search->provinces)) {
            $query = $query
                ->andWhere('p.id IN (:provinces)')
                ->setParameter('provinces', $search->provinces);
        }

        return $query->getQuery()->getResult();
    }




    // /**
    //  * @return Centre[] Returns an array of Centre objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Centre
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
