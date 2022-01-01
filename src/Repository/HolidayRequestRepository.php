<?php

namespace App\Repository;

use App\Entity\HolidayRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method HolidayRequest|null find($id, $lockMode = null, $lockVersion = null)
 * @method HolidayRequest|null findOneBy(array $criteria, array $orderBy = null)
 * @method HolidayRequest[]    findAll()
 * @method HolidayRequest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HolidayRequestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HolidayRequest::class);
    }

    /**
     * @param $field
     * @param $value
     * @return int|mixed|string
     */
    public function findByNot($field, $value)
    {
        $qb = $this->createQueryBuilder('a');
        $qb->where($qb->expr()->not($qb->expr()->eq('a.'.$field, '?1')));
        $qb->setParameter(1, $value);

        return $qb->getQuery()
            ->getResult();
    }

    // /**
    //  * @return HolidayRequest[] Returns an array of HolidayRequest objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?HolidayRequest
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
