<?php

namespace App\Entity;

<<<<<<< HEAD
<<<<<<< HEAD
use App\Repository\OffreRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

=======
use App\Entity\Demande;
use App\Entity\Utilisateur;
=======
<<<<<<< HEAD
use App\Repository\OffreRepository;
>>>>>>> c139a4e (Résolution des conflits)
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;

<<<<<<< HEAD
#[ORM\Entity]
=======
>>>>>>> Salles
#[ORM\Entity(repositoryClass: OffreRepository::class)]
=======
use App\Entity\Demande;
use App\Entity\Utilisateur;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
>>>>>>> 6ab9b1d (Initial commit)
<<<<<<< HEAD
=======
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles
class Offre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id_offre', type: 'integer')]
<<<<<<< HEAD
<<<<<<< HEAD
    private ?int $id = null;

    #[ORM\Column(name: 'titre_offre', type: 'string', length: 255)]
    private ?string $titreOffre = null;

    #[ORM\Column(name: 'description_offre', type: Types::TEXT)]
    private ?string $descriptionOffre = null;

    #[ORM\Column(name: 'type_offre', type: 'string', length: 255)]
    private ?string $typeOffre = null;

    #[ORM\Column(name: 'montant', type: Types::FLOAT)]
    private ?float $montant = null;

=======
    private ?int $idOffre = null;
=======
<<<<<<< HEAD
    private ?int $id = null;
>>>>>>> c139a4e (Résolution des conflits)

    #[Assert\NotBlank(message: "Le titre de l'offre est obligatoire.")]
    #[Assert\Length(
        min: 5,
        max: 255,
        minMessage: "Le titre doit contenir au moins {{ limit }} caractères.",
        maxMessage: "Le titre ne peut pas dépasser {{ limit }} caractères."
    )]
    #[ORM\Column(name: 'titre_offre', type: 'string', length: 255)]
    private ?string $titreOffre = null;

    #[Assert\NotBlank(message: "La description de l'offre est obligatoire.")]
    #[Assert\Length(
        min: 10,
        minMessage: "La description doit faire au moins {{ limit }} caractères."
    )]
    #[ORM\Column(name: 'description_offre', type: Types::TEXT)]
    private ?string $descriptionOffre = null;

    #[Assert\NotBlank(message: "Le type d'offre est requis.")]
    #[ORM\Column(name: 'type_offre', type: 'string', length: 255)]
    private ?string $typeOffre = null;

    #[Assert\NotBlank(message: "Le montant est requis.")]
    #[Assert\Positive(message: "Le montant doit être positif.")]
    #[ORM\Column(name: 'montant', type: Types::FLOAT)]
    private ?float $montant = null;

<<<<<<< HEAD
    #[Assert\NotBlank(message: "La date d'expiration est obligatoire.")]
    #[Assert\GreaterThan("today", message: "La date d'expiration doit être dans le futur.")]
    #[ORM\Column(name: 'date_exp', type: Types::DATE_MUTABLE, nullable: true)]
=======
>>>>>>> Salles
    #[ORM\Column(name: 'date_exp', type: Types::DATE_MUTABLE)]
=======
    private ?int $idOffre = null;

    #[Assert\NotBlank(message: "Le titre de l'offre est obligatoire.")]
    #[Assert\Length(
        min: 5,
        max: 255,
        minMessage: "Le titre doit contenir au moins {{ limit }} caractères.",
        maxMessage: "Le titre ne peut pas dépasser {{ limit }} caractères."
    )]
    #[ORM\Column(name: 'titre_offre', type: 'string', length: 255)]
    private ?string $titreOffre = null;

    #[Assert\NotBlank(message: "La description de l'offre est obligatoire.")]
    #[Assert\Length(
        min: 10,
        minMessage: "La description doit faire au moins {{ limit }} caractères."
    )]
    #[ORM\Column(name: 'description_offre', type: Types::TEXT)]
    private ?string $descriptionOffre = null;

    #[Assert\NotBlank(message: "Le type d'offre est requis.")]
    #[ORM\Column(name: 'type_offre', type: 'string', length: 255)]
    private ?string $typeOffre = null;

    #[Assert\NotBlank(message: "Le montant est requis.")]
    #[Assert\Positive(message: "Le montant doit être positif.")]
    #[ORM\Column(name: 'montant', type: Types::FLOAT)]
    private ?float $montant = null;

    #[Assert\NotBlank(message: "La date d'expiration est obligatoire.")]
    #[Assert\GreaterThan("today", message: "La date d'expiration doit être dans le futur.")]
    #[ORM\Column(name: 'date_exp', type: Types::DATE_MUTABLE, nullable: true)]
>>>>>>> 6ab9b1d (Initial commit)
<<<<<<< HEAD
=======
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles
    private ?\DateTimeInterface $dateExp = null;

    #[ORM\Column(name: 'evenement', type: 'integer', nullable: true)]
    private ?int $evenement = null;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', nullable: true)]
    private ?Utilisateur $utilisateur = null;

<<<<<<< HEAD
<<<<<<< HEAD
=======
    #[ORM\OneToMany(mappedBy: 'offre', targetEntity: Demande::class, orphanRemoval: true)]
    private Collection $demandes;

    public function __construct()
    {
        $this->demandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
=======
<<<<<<< HEAD
>>>>>>> Salles
    // 🔽 Getters and Setters 🔽

    public function getId(): ?int
    {
        return $this->id;
=======
    #[ORM\OneToMany(mappedBy: 'offre', targetEntity: Demande::class, orphanRemoval: true)]
    private Collection $demandes;

    public function __construct()
    {
        $this->demandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
<<<<<<< HEAD
=======
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles
        return $this->idOffre;
    }

    public function setIdOffre(int $idOffre): self
    {
        $this->idOffre = $idOffre;
        return $this;
<<<<<<< HEAD
>>>>>>> 6ab9b1d (Initial commit)
=======
<<<<<<< HEAD
=======
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles
    }

    public function getTitreOffre(): ?string
    {
        return $this->titreOffre;
    }

<<<<<<< HEAD
<<<<<<< HEAD
=======
    public function setTitreOffre(string $titreOffre): self
=======
<<<<<<< HEAD
>>>>>>> Salles
    public function setTitreOffre(string $titreOffre): static
=======
    public function setTitreOffre(string $titreOffre): self
>>>>>>> 6ab9b1d (Initial commit)
<<<<<<< HEAD
=======
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles
    {
        $this->titreOffre = $titreOffre;
        return $this;
    }

    public function getDescriptionOffre(): ?string
    {
        return $this->descriptionOffre;
    }

<<<<<<< HEAD
<<<<<<< HEAD
=======
    public function setDescriptionOffre(string $descriptionOffre): self
=======
<<<<<<< HEAD
>>>>>>> Salles
    public function setDescriptionOffre(string $descriptionOffre): static
=======
    public function setDescriptionOffre(string $descriptionOffre): self
>>>>>>> 6ab9b1d (Initial commit)
<<<<<<< HEAD
=======
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles
    {
        $this->descriptionOffre = $descriptionOffre;
        return $this;
    }

    public function getTypeOffre(): ?string
    {
        return $this->typeOffre;
    }

<<<<<<< HEAD
<<<<<<< HEAD
=======
    public function setTypeOffre(string $typeOffre): self
=======
<<<<<<< HEAD
>>>>>>> Salles
    public function setTypeOffre(string $typeOffre): static
=======
    public function setTypeOffre(string $typeOffre): self
>>>>>>> 6ab9b1d (Initial commit)
<<<<<<< HEAD
=======
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles
    {
        $this->typeOffre = $typeOffre;
        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

<<<<<<< HEAD
<<<<<<< HEAD
=======
    public function setMontant(float $montant): self
=======
<<<<<<< HEAD
>>>>>>> Salles
    public function setMontant(float $montant): static
=======
    public function setMontant(float $montant): self
>>>>>>> 6ab9b1d (Initial commit)
<<<<<<< HEAD
=======
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles
    {
        $this->montant = $montant;
        return $this;
    }

    public function getDateExp(): ?\DateTimeInterface
    {
        return $this->dateExp;
    }

<<<<<<< HEAD
<<<<<<< HEAD
=======
=======
<<<<<<< HEAD
>>>>>>> Salles
    public function setDateExp(\DateTimeInterface $dateExp): static
    {
        $this->dateExp = $dateExp;
        return $this;
    }
=======
<<<<<<< HEAD
=======
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles
    public function setDateExp(?\DateTimeInterface $dateExp): self
{
    $this->dateExp = $dateExp;
    return $this;
}

<<<<<<< HEAD
>>>>>>> 6ab9b1d (Initial commit)
=======
<<<<<<< HEAD
=======
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles

    public function getEvenement(): ?int
    {
        return $this->evenement;
    }

<<<<<<< HEAD
<<<<<<< HEAD
=======
    public function setEvenement(?int $evenement): self
=======
<<<<<<< HEAD
>>>>>>> Salles
    public function setEvenement(?int $evenement): static
=======
    public function setEvenement(?int $evenement): self
>>>>>>> 6ab9b1d (Initial commit)
<<<<<<< HEAD
=======
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles
    {
        $this->evenement = $evenement;
        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

<<<<<<< HEAD
<<<<<<< HEAD
=======
    public function setUtilisateur(?Utilisateur $utilisateur): self
=======
<<<<<<< HEAD
>>>>>>> Salles
    public function setUtilisateur(?Utilisateur $utilisateur): static
=======
    public function setUtilisateur(?Utilisateur $utilisateur): self
>>>>>>> 6ab9b1d (Initial commit)
<<<<<<< HEAD
=======
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles
    {
        $this->utilisateur = $utilisateur;
        return $this;
    }
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles

    /**
     * @return Collection<int, Demande>
     */
    public function getDemandes(): Collection
    {
        return $this->demandes;
    }

    public function addDemande(Demande $demande): self
    {
        if (!$this->demandes->contains($demande)) {
            $this->demandes[] = $demande;
            $demande->setOffre($this);
        }

        return $this;
    }

    public function removeDemande(Demande $demande): self
    {
        if ($this->demandes->removeElement($demande)) {
            if ($demande->getOffre() === $this) {
                $demande->setOffre(null);
            }
        }

        return $this;
    }
<<<<<<< HEAD
>>>>>>> 6ab9b1d (Initial commit)
=======
<<<<<<< HEAD
=======
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles
}
