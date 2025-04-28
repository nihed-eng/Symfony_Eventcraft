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

<<<<<<< HEAD
    /**
     * Retourne une requête paginable de toutes les décorations
     */
    public function findAllQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('d')
                    ->orderBy('d.nomDecor', 'ASC'); // ajuste le champ si besoin
    }
}
=======
    public function findAllQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('d')
            ->orderBy('d.nomDecor', 'ASC');
    }

    public function findByType(string $type): array
    {
        return $this->createQueryBuilder('d')
            ->where('d.typeDecor = :type')
            ->setParameter('type', $type)
            ->orderBy('d.nomDecor', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findInStock(): array
    {
        return $this->createQueryBuilder('d')
            ->where('d.stock > 0')
            ->orderBy('d.nomDecor', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function searchByTerm(string $term): array
    {
        return $this->createQueryBuilder('d')
            ->where('d.nomDecor LIKE :term')
            ->orWhere('d.descriptionDecor LIKE :term')
            ->setParameter('term', '%'.$term.'%')
            ->orderBy('d.nomDecor', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function save(Decoration $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Decoration $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
>>>>>>> 6ab9b1d (Initial commit)
