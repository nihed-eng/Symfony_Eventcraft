<?php

namespace App\Repository;

use App\Entity\Reservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reservation>
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    // Tu pourras ajouter ici des méthodes personnalisées si besoin, exemple :

    /**
     * @return Reservation[] Returns an array of Reservation objects
     */
    public function findBySomeField($value): array
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.someField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
}
