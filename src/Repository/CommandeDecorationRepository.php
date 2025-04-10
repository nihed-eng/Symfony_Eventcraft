<?php

namespace App\Repository;

use App\Entity\CommandeDecoration;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CommandeDecoration|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommandeDecoration|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommandeDecoration[]    findAll()
 * @method CommandeDecoration[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeDecorationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommandeDecoration::class);
    }

    // Ajoutez des méthodes personnalisées si nécessaire

    /**
     * Exemple de méthode personnalisée pour récupérer des commandes par statut.
     *
     * @param string $status
     * @return CommandeDecoration[]
     */
    public function findByStatus(string $status)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.status = :status')
            ->setParameter('status', $status)
            ->orderBy('c.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
