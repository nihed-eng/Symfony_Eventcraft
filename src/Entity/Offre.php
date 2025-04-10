<?php

namespace App\Entity;

use App\Repository\OffreRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: OffreRepository::class)]
class Offre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id_offre', type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(name: 'titre_offre', type: 'string', length: 255)]
    private ?string $titreOffre = null;

    #[ORM\Column(name: 'description_offre', type: Types::TEXT)]
    private ?string $descriptionOffre = null;

    #[ORM\Column(name: 'type_offre', type: 'string', length: 255)]
    private ?string $typeOffre = null;

    #[ORM\Column(name: 'montant', type: Types::FLOAT)]
    private ?float $montant = null;

    #[ORM\Column(name: 'date_exp', type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateExp = null;

    #[ORM\Column(name: 'evenement', type: 'integer', nullable: true)]
    private ?int $evenement = null;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', nullable: true)]
    private ?Utilisateur $utilisateur = null;

    // 🔽 Getters and Setters 🔽

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitreOffre(): ?string
    {
        return $this->titreOffre;
    }

    public function setTitreOffre(string $titreOffre): static
    {
        $this->titreOffre = $titreOffre;
        return $this;
    }

    public function getDescriptionOffre(): ?string
    {
        return $this->descriptionOffre;
    }

    public function setDescriptionOffre(string $descriptionOffre): static
    {
        $this->descriptionOffre = $descriptionOffre;
        return $this;
    }

    public function getTypeOffre(): ?string
    {
        return $this->typeOffre;
    }

    public function setTypeOffre(string $typeOffre): static
    {
        $this->typeOffre = $typeOffre;
        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): static
    {
        $this->montant = $montant;
        return $this;
    }

    public function getDateExp(): ?\DateTimeInterface
    {
        return $this->dateExp;
    }

    public function setDateExp(\DateTimeInterface $dateExp): static
    {
        $this->dateExp = $dateExp;
        return $this;
    }

    public function getEvenement(): ?int
    {
        return $this->evenement;
    }

    public function setEvenement(?int $evenement): static
    {
        $this->evenement = $evenement;
        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): static
    {
        $this->utilisateur = $utilisateur;
        return $this;
    }
}
