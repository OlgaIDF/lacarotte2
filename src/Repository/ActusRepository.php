<?php

namespace App\Repository;

use App\Entity\Actus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Actus|null find($id, $lockMode = null, $lockVersion = null)
 * @method Actus|null findOneBy(array $criteria, array $orderBy = null)
 * @method Actus[]    findAll()
 * @method Actus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Actus::class);
    }

    // /**
    //  * @return Actus[] Returns an array of Actus objects
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
    public function findOneBySomeField($value): ?Actus
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findSix() /* pour ne sélectionner que 6 actus*/
    {
        return $this->createQueryBuilder('s') /* 's' est un alias */
            ->andWhere('s.id > :val') /* on cherhce un id supérieur à une valeur */
            ->setParameter('val', '0') /* on donne la valeur */
            ->orderBy('s.id', 'DESC') /* tri en ordre décroissant */
            ->setMaxResults(6) /* on sélectionne 6 résultats maximum */
            ->getQuery() /* requête */
            ->getResult() /* résultats */
        ;
    }
}
