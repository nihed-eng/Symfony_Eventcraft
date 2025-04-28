<?php

namespace App\Entity;

use App\Repository\DecorationRepository;
use Doctrine\ORM\Mapping as ORM;
<<<<<<< HEAD
<<<<<<< HEAD
=======
use Symfony\Component\Validator\Constraints as Assert;
>>>>>>> 6ab9b1d (Initial commit)
=======
use Symfony\Component\Validator\Constraints as Assert;
=======
<<<<<<< HEAD
=======
use Symfony\Component\Validator\Constraints as Assert;
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles

#[ORM\Entity(repositoryClass: DecorationRepository::class)]
class Decoration
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(name: 'id_decor', type: 'integer')]
    private int $idDecor;

    #[ORM\Column(name: 'nom_decor', type: 'string', length: 255)]
<<<<<<< HEAD
<<<<<<< HEAD
    private string $nomDecor;

    #[ORM\Column(name: 'type_decor', type: 'string', length: 255)]
    private string $typeDecor;

    #[ORM\Column(name: 'description_decor', type: 'string', length: 255)]
    private string $descriptionDecor;

    #[ORM\Column(name: 'stock', type: 'integer')]
    private int $stock;

=======
    #[Assert\NotBlank(message: "Le nom ne peut pas être vide")]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: "Le nom doit contenir au moins {{ limit }} caractères",
        maxMessage: "Le nom ne peut pas dépasser {{ limit }} caractères"
    )]
=======
<<<<<<< HEAD
>>>>>>> c139a4e (Résolution des conflits)
    private string $nomDecor;

    #[ORM\Column(name: 'type_decor', type: 'string', length: 255)]
    #[Assert\NotBlank(message: "Le type ne peut pas être vide")]
    #[Assert\Length(
        min: 2,
        max: 30,
        minMessage: "Le type doit contenir au moins {{ limit }} caractères",
        maxMessage: "Le type ne peut pas dépasser {{ limit }} caractères"
    )]
    private string $typeDecor;

    #[ORM\Column(name: 'description_decor', type: 'string', length: 500)]
    #[Assert\NotBlank(message: "La description ne peut pas être vide")]
    #[Assert\Length(
        min: 10,
        max: 500,
        minMessage: "La description doit contenir au moins {{ limit }} caractères",
        maxMessage: "La description ne peut pas dépasser {{ limit }} caractères"
    )]
    private ?string $descriptionDecor;

    #[ORM\Column(name: 'stock', type: 'integer')]
    #[Assert\NotBlank(message: "Le stock ne peut pas être vide")]
    #[Assert\PositiveOrZero(message: "Le stock doit être un nombre positif ou zéro")]
    private int $stock;

<<<<<<< HEAD
    #[ORM\Column(name: 'prix', type: 'float', precision: 10, scale: 2)]
    #[Assert\NotBlank(message: "Le prix ne peut pas être vide")]
    #[Assert\Positive(message: "Le prix doit être un nombre positif")]
=======
>>>>>>> Salles
    #[ORM\Column(name: 'prix', type: 'float', precision: 10, scale: 0)]
=======
    #[Assert\NotBlank(message: "Le nom ne peut pas être vide")]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: "Le nom doit contenir au moins {{ limit }} caractères",
        maxMessage: "Le nom ne peut pas dépasser {{ limit }} caractères"
    )]
    private string $nomDecor;

    #[ORM\Column(name: 'type_decor', type: 'string', length: 255)]
    #[Assert\NotBlank(message: "Le type ne peut pas être vide")]
    #[Assert\Length(
        min: 2,
        max: 30,
        minMessage: "Le type doit contenir au moins {{ limit }} caractères",
        maxMessage: "Le type ne peut pas dépasser {{ limit }} caractères"
    )]
    private string $typeDecor;

    #[ORM\Column(name: 'description_decor', type: 'string', length: 500)]
    #[Assert\NotBlank(message: "La description ne peut pas être vide")]
    #[Assert\Length(
        min: 10,
        max: 500,
        minMessage: "La description doit contenir au moins {{ limit }} caractères",
        maxMessage: "La description ne peut pas dépasser {{ limit }} caractères"
    )]
    private ?string $descriptionDecor;

    #[ORM\Column(name: 'stock', type: 'integer')]
    #[Assert\NotBlank(message: "Le stock ne peut pas être vide")]
    #[Assert\PositiveOrZero(message: "Le stock doit être un nombre positif ou zéro")]
    private int $stock;

    #[ORM\Column(name: 'prix', type: 'float', precision: 10, scale: 2)]
    #[Assert\NotBlank(message: "Le prix ne peut pas être vide")]
    #[Assert\Positive(message: "Le prix doit être un nombre positif")]
>>>>>>> 6ab9b1d (Initial commit)
<<<<<<< HEAD
=======
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles
    private float $prix;

    #[ORM\Column(name: 'imageDeco', type: 'string', length: 255, nullable: true)]
    private ?string $imagedeco = null;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
<<<<<<< HEAD
<<<<<<< HEAD
=======
    private ?Utilisateur $user = null;
=======
<<<<<<< HEAD
>>>>>>> Salles
    private ?Utilisateur $user;

    // Getters and Setters
=======
    private ?Utilisateur $user = null;
>>>>>>> 6ab9b1d (Initial commit)
<<<<<<< HEAD
=======
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles

    public function getIdDecor(): int
    {
        return $this->idDecor;
    }

    public function setIdDecor(int $idDecor): self
    {
        $this->idDecor = $idDecor;
        return $this;
    }

    public function getNomDecor(): string
    {
        return $this->nomDecor;
    }

    public function setNomDecor(string $nomDecor): self
    {
        $this->nomDecor = $nomDecor;
        return $this;
    }

    public function getTypeDecor(): string
    {
        return $this->typeDecor;
    }

    public function setTypeDecor(string $typeDecor): self
    {
        $this->typeDecor = $typeDecor;
        return $this;
    }

<<<<<<< HEAD
<<<<<<< HEAD
=======
    public function getDescriptionDecor(): ?string
=======
<<<<<<< HEAD
>>>>>>> Salles
    public function getDescriptionDecor(): string
=======
    public function getDescriptionDecor(): ?string
>>>>>>> 6ab9b1d (Initial commit)
<<<<<<< HEAD
=======
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles
    {
        return $this->descriptionDecor;
    }

    public function setDescriptionDecor(string $descriptionDecor): self
    {
        $this->descriptionDecor = $descriptionDecor;
        return $this;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;
        return $this;
    }

    public function getPrix(): float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;
        return $this;
    }

    public function getImagedeco(): ?string
    {
        return $this->imagedeco;
    }

    public function setImagedeco(?string $imagedeco): self
    {
        $this->imagedeco = $imagedeco;
        return $this;
    }

    public function getUser(): ?Utilisateur
    {
        return $this->user;
    }

    public function setUser(?Utilisateur $user): self
    {
        $this->user = $user;
        return $this;
    }
<<<<<<< HEAD
}
=======
<<<<<<< HEAD
}
>>>>>>> 6ab9b1d (Initial commit)
=======
<<<<<<< HEAD
}
=======
}
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles
