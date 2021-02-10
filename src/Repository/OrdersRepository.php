<?php

namespace App\Repository;

use App\Entity\Orders;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Orders|null find($id, $lockMode = null, $lockVersion = null)
 * @method Orders|null findOneBy(array $criteria, array $orderBy = null)
 * @method Orders[]    findAll()
 * @method Orders[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrdersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Orders::class);
    }

    public function findById() /* pour ne sélectionner que 6 actus*/
    {
        return $this->createQueryBuilder('s') /* 's' est un alias */
            ->andWhere('s.id > :val') /* on cherhce un id supérieur à une valeur */
            ->setParameter('val', '0') /* on donne la valeur */
            ->orderBy('s.id', 'DESC') /* tri en ordre décroissant */
            ->getQuery() /* requête */
            ->getResult() /* résultats */
        ;
    }

    /**
     * get paid orders to display in user account
     */
    public function findBySuccessOrders($user)
    {
        return $this->createQueryBuilder('o')
        ->andWhere('o.state >= 1')
        ->andWhere('o.user = :user')
        ->setParameter('user', $user)
        ->orderBy('o.id', 'DESC')
        ->getQuery()
        ->getResult();
    }
    // /**
    //  * @return Orders[] Returns an array of Orders objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Orders
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
