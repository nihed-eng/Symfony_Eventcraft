<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class CommandeDecorationStatsService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getTotalQuantiteByDecoration(): array
    {
        $qb = $this->entityManager->createQueryBuilder();

        $qb->select('d.nomDecor AS nom_decor, SUM(c.quantite) AS total_quantity')
            ->from('App\Entity\CommandeDecoration', 'c')
            ->join('c.decoration', 'd')
            ->groupBy('d.idDecor');

        return $qb->getQuery()->getResult();
    }

    public function getTotalPriceByDecoration(): array
    {
        $qb = $this->entityManager->createQueryBuilder();

        $qb->select('d.nomDecor AS nom_decor, SUM(c.prix) AS total_price')
            ->from('App\Entity\CommandeDecoration', 'c')
            ->join('c.decoration', 'd')
            ->groupBy('d.idDecor');

        return $qb->getQuery()->getResult();
    }
}
