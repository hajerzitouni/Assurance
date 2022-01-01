<?php

namespace App\Repository;

use App\Entity\ValidatedHolidayBy;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ValidatedHolidayBy|null find($id, $lockMode = null, $lockVersion = null)
 * @method ValidatedHolidayBy|null findOneBy(array $criteria, array $orderBy = null)
 * @method ValidatedHolidayBy[]    findAll()
 * @method ValidatedHolidayBy[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ValidatedHolidayByRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ValidatedHolidayBy::class);
    }

    // /**
    //  * @return ValidatedHolidayBy[] Returns an array of ValidatedHolidayBy objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ValidatedHolidayBy
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
