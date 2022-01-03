<?php

namespace App\Repository;

use App\Entity\Booking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class BookingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Booking::class);
    }

    public  function findBydate($m){
        /*  $query= $this->getEntityManager()->createQueryBuilder()
          ->select('p')->from('ecommerceBundle:Panier','p')->where('p.user_id= :user')->setParameter('user',"%{$user}%");

              return $query->getResult();
  */

        $query = $this->getEntityManager()->createQuery("SELECT b FROM  App\Entity\Booking AS b WHERE  MONTH (b.beginAt)=:m")->setParameter('m',$m);


        try {
            return $query->getOneOrNullResult();
        } catch (NoResultException $e) {
            return null;
        } catch (NonUniqueResultException $e) {
            return null;
        }

    }
}