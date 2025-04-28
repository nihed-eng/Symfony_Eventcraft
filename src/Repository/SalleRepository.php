<?php
// src/Repository/SalleRepository.php

namespace App\Repository;

use App\Entity\Salle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class SalleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Salle::class);
    }

<<<<<<< HEAD
=======
<<<<<<< HEAD
    // Ajoutez ici vos méthodes personnalisées si nécessaire
=======
>>>>>>> c139a4e (Résolution des conflits)
    public function findWithFilters(array $filters)
    {
        $qb = $this->createQueryBuilder('s');
    
        if (!empty($filters['location'])) {
            $qb->andWhere('s.localisation LIKE :location')
               ->setParameter('location', '%'.$filters['location'].'%');
        }
    
        if (!empty($filters['date_start'])) {
            $qb->andWhere('s.disponibilite >= :dateStart')
               ->setParameter('dateStart', new \DateTime($filters['date_start']));
        }
    
        if (!empty($filters['date_end'])) {
            $qb->andWhere('s.disponibilite <= :dateEnd')
               ->setParameter('dateEnd', new \DateTime($filters['date_end']));
        }
    
        if (!empty($filters['capacity'])) {
            $qb->andWhere('s.capacite >= :capacity')
               ->setParameter('capacity', $filters['capacity']);
        }
    
        if (!empty($filters['max_price'])) {
            $qb->andWhere('s.prix <= :maxPrice')
               ->setParameter('maxPrice', $filters['max_price']);
        }
    
        return $qb->getQuery()->getResult();
    }

<<<<<<< HEAD
=======
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)
}
