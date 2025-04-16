<?php

namespace App\Entity;

use App\Repository\ParticipationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ParticipationRepository::class)]
class Participation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id_participation')]
    private ?int $id = null;  // Changed from $id_participation to $id

    #[ORM\Column(name: 'evenement_id')]
    #[Assert\NotBlank(message: "Please provide a value")]
    private ?int $evenementId = null;  // Changed to camelCase

    #[ORM\Column(name: 'user_id')]
    #[Assert\NotBlank(message: "Please provide a value")]

    private ?int $userId = null;  // Changed to camelCase

    #[ORM\Column(length: 30)]
    #[Assert\NotBlank(message: "The status cannot be blank")]
    private ?string $statut = null;

    #[ORM\Column(name: 'date_inscription', type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message: "The date cannot be blank")]
    private ?\DateTimeInterface $dateInscription = null;

    #[ORM\ManyToOne(targetEntity: Evenement::class, inversedBy: 'participations')]
    #[ORM\JoinColumn(name: 'evenement_id', referencedColumnName: 'id_evenement', nullable: false)]
    private ?Evenement $evenement = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEvenementId(): ?int
    {
        return $this->evenementId;
    }

    public function setEvenementId(int $evenementId): static
    {
        $this->evenementId = $evenementId;
        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): static
    {
        $this->userId = $userId;
        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;
        return $this;
    }

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->dateInscription;
    }

    public function setDateInscription(\DateTimeInterface $dateInscription): static
    {
        $this->dateInscription = $dateInscription;
        return $this;
    }

    public function getEvenement(): ?Evenement
    {
        return $this->evenement;
    }

    public function setEvenement(?Evenement $evenement): static
    {
        $this->evenement = $evenement;

        return $this;
    }

    
}