<?php

<<<<<<< HEAD

namespace App\Entity;

use App\Repository\DemandeRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: DemandeRepository::class)]
=======
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
>>>>>>> 6ab9b1d (Initial commit)
class Demande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
<<<<<<< HEAD
    #[ORM\Column]
    private ?int $idDemande = null;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class, inversedBy: 'demandes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $user = null;

    
    #[ORM\Column(length: 255)]
    private ?string $statutDemande = 'En attente';
    #[ORM\Column(type: 'text')]
    #[Assert\NotBlank(message: "La description est obligatoire.")]
    #[Assert\Length(
        min: 10,
        minMessage: "La description doit contenir au moins {{ limit }} caractères."
    )]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom est obligatoire.")]
    #[Assert\Length(
        min: 3,
        max: 100,
        minMessage: "Le nom doit contenir au moins {{ limit }} caractères.",
        maxMessage: "Le nom ne peut pas dépasser {{ limit }} caractères."
    )]
        private string $nom;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateDemande = null;

=======
    #[ORM\Column(name: 'id_demande', type: 'integer')]
    private ?int $idDemande = null;

    #[ORM\Column(name: 'nom', type: 'string', length: 255)]
    #[Assert\NotBlank(message: 'Le nom ne peut pas être vide.')]
    #[Assert\Length(max: 255, maxMessage: 'Le nom ne peut pas dépasser {{ limit }} caractères.')]
    private ?string $nom = null;

    #[ORM\Column(name: 'description', type: Types::TEXT)]
    #[Assert\NotBlank(message: 'La description ne peut pas être vide.')]
    #[Assert\Length(min: 10, minMessage: 'La description doit comporter au moins {{ limit }} caractères.')]
    private ?string $description = null;

    #[ORM\Column(name: 'statut_demande', type: 'string', length: 255)]
    #[Assert\Choice(
        choices: ['En attente', 'Approuvée', 'Rejetée'],
        message: 'Le statut "{{ value }}" n\'est pas valide. Choisissez parmi "En attente", "Approuvée" ou "Rejetée".'
    )]
    private ?string $statutDemande = 'En attente';

    #[ORM\Column(name: 'date_demande', type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateDemande = null;

    #[ORM\ManyToOne(targetEntity: Offre::class)]
    #[ORM\JoinColumn(name: 'offre', referencedColumnName: 'id_offre', nullable: true)]
    private ?Offre $offre = null;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', nullable: true)]
    private ?Utilisateur $utilisateur = null;

    public function __construct()
    {
        $this->dateDemande = new \DateTime();  // Date actuelle par défaut
    }

    // Getters et Setters pour chaque champ...

>>>>>>> 6ab9b1d (Initial commit)
    public function getIdDemande(): ?int
    {
        return $this->idDemande;
    }

<<<<<<< HEAD
    public function getUser(): ?Utilisateur
    {
        return $this->user;
    }

    public function setUser(?Utilisateur $user): static
    {
        $this->user = $user;
        return $this;
    }

   

    public function getStatutDemande(): ?string
    {
        return $this->statutDemande;
    }

    public function setStatutDemande(string $statutDemande): static
    {
        $this->statutDemande = $statutDemande;
        return $this;
    }

    public function getDateDemande(): ?\DateTimeInterface
    {
        return $this->dateDemande;
    }

    public function setDateDemande(\DateTimeInterface $dateDemande): static
    {
        $this->dateDemande = $dateDemande;
        return $this;
    }
    
    // Getters and Setters
    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

=======
>>>>>>> 6ab9b1d (Initial commit)
    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }
<<<<<<< HEAD
}  
=======

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getStatutDemande(): ?string
    {
        return $this->statutDemande;
    }

    public function setStatutDemande(string $statutDemande): self
    {
        $this->statutDemande = $statutDemande;
        return $this;
    }

    public function getDateDemande(): ?\DateTimeInterface
    {
        return $this->dateDemande;
    }

    public function setDateDemande(\DateTimeInterface $dateDemande): self
    {
        $this->dateDemande = $dateDemande;
        return $this;
    }

    public function getOffre(): ?Offre
    {
        return $this->offre;
    }

    public function setOffre(?Offre $offre): self
    {
        $this->offre = $offre;
        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;
        return $this;
    }
}
>>>>>>> 6ab9b1d (Initial commit)
