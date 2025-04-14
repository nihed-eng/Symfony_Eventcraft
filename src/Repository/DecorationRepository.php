<?php

namespace App\Repository;

use App\Entity\Decoration;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

class DecorationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Decoration::class);
    }

    /**
     * Retourne une requête paginable de toutes les décorations
     */
    public function findAllQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('d')
                    ->orderBy('d.nomDecor', 'ASC'); // ajuste le champ si besoin
    }
}
