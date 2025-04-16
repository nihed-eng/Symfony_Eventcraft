<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'reservation')]
#[ORM\Index(name: 'fk_reservation_salle', columns: ['salle'])]
#[ORM\Index(name: 'fk_reservation_user', columns: ['user_id'])]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(name: 'id_reservation', type: 'integer')]
    private int $idReservation;

    #[ORM\Column(name: 'date_debut', type: 'datetime')]
    private \DateTime $dateDebut;

    #[ORM\Column(name: 'date_fin', type: 'datetime')]
    private \DateTime $dateFin;

    #[ORM\ManyToOne(targetEntity: Salle::class)]
    #[ORM\JoinColumn(name: 'salle', referencedColumnName: 'id_salle')]
    private ?Salle $salle;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private ?Utilisateur $user;

// Dans App\Entity\Reservation

public function getIdReservation(): ?int
{
    return $this->idReservation;
}

public function getDateDebut(): ?\DateTime
{
    return $this->dateDebut;
}

public function getDateFin(): ?\DateTime
{
    return $this->dateFin;
}

public function getSalle(): ?Salle
{
    return $this->salle;
}

public function getUser(): ?Utilisateur
{
    return $this->user;
}
// Ajoutez ces méthodes à votre entité Reservation

public function setDateDebut(\DateTimeInterface $dateDebut): self
{
    $this->dateDebut = $dateDebut;
    return $this;
}

public function setDateFin(\DateTimeInterface $dateFin): self
{
    $this->dateFin = $dateFin;
    return $this;
}

public function setSalle(?Salle $salle): self
{
    $this->salle = $salle;
    return $this;
}

public function setUser(?Utilisateur $user): self
{
    $this->user = $user;
    return $this;
}
}