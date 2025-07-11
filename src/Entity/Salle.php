<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: 'salle')]
class Salle
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(name: 'id_salle', type: 'integer')]
    private int $idSalle;

    #[ORM\Column(name: 'nom_salle', type: 'string', length: 255)]
    #[Assert\NotBlank(message: "Le nom de la salle est obligatoire")]
    #[Assert\Length(
        min: 3,
        max: 255,
        minMessage: "Le nom doit faire au moins {{ limit }} caractères",
        maxMessage: "Le nom ne peut pas dépasser {{ limit }} caractères"
    )]
<<<<<<< HEAD
    private ?string $nomSalle = null;
=======
<<<<<<< HEAD
    private string $nomSalle;
=======
    private ?string $nomSalle = null;
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)

    #[ORM\Column(name: 'capacité', type: 'string', length: 255)]
    #[Assert\NotBlank(message: "La capacité est obligatoire")]
    #[Assert\Regex(
        pattern: "/^[0-9]+$/",
        message: "La capacité doit être un nombre"
    )]
    private string $capacite;

    #[ORM\Column(name: 'équipement', type: 'string', length: 255)]
    #[Assert\NotBlank(message: "L'équipement est obligatoire")]
    private string $equipement;

    #[ORM\Column(name: 'image_salle', type: 'string', length: 255)]
<<<<<<< HEAD
    
=======
<<<<<<< HEAD
    #[Assert\Image(
        maxSize: "2M",
        mimeTypes: ["image/jpeg", "image/png", "image/webp"],
        mimeTypesMessage: "Veuillez uploader une image valide (JPEG, PNG ou WEBP)"
    )]
=======
    
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)
    private ?string $imageSalle = null;

    #[ORM\Column(name: 'location_salle', type: 'string', length: 255)]
    #[Assert\NotBlank(message: "La localisation est obligatoire")]
    private string $locationSalle;

    #[ORM\Column(name: 'qualite', type: 'string', length: 255, nullable: true)]
<<<<<<< HEAD
    #[Assert\NotBlank(message: "La qualité est obligatoire")]
    #[Assert\Choice(
        choices: ["Bien", "Très bien", "Superbe", "Exceptionnelle"],
        message: "Choisissez une qualité valide"
=======
<<<<<<< HEAD
    #[Assert\Choice(
        choices: ["standard", "premium", "luxe"],
        message: "Choisissez une qualité valide (standard, premium ou luxe)"
=======
    #[Assert\NotBlank(message: "La qualité est obligatoire")]
    #[Assert\Choice(
        choices: ["Bien", "Très bien", "Superbe", "Exceptionnelle"],
        message: "Choisissez une qualité valide"
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)
    )]
    private ?string $qualite;

    #[ORM\Column(name: 'prix', type: 'decimal', precision: 10, scale: 2, nullable: true)]
    #[Assert\NotBlank(message: "Le prix est obligatoire")]
    #[Assert\Positive(message: "Le prix doit être positif")]
    #[Assert\Type(
        type: "numeric",
        message: "Le prix doit être un nombre"
    )]
    private ?string $prix;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
<<<<<<< HEAD
    #[Assert\NotBlank(message: "L’utilisateur est obligatoire")]
    private ?Utilisateur $user;



=======
<<<<<<< HEAD
    private ?Utilisateur $user;


=======
    #[Assert\NotBlank(message: "L’utilisateur est obligatoire")]
    private ?Utilisateur $user;



>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)
    public function getIdSalle(): int
    {
        return $this->idSalle;
    }

    public function getNomSalle(): string
    {
        return $this->nomSalle;
    }
    public function setNomSalle(string $nomSalle): self
    {
        $this->nomSalle = $nomSalle;
        return $this;
    }
    public function getCapacite(): ?string
    {
        return $this->capacite;
    }
    
    public function setCapacite(string $capacite): self
    {
        $this->capacite = $capacite;
        return $this;
    }

    public function getEquipement(): string
    {
        return $this->equipement;
    }

    // Setter pour "equipement"
    public function setEquipement(string $equipement): self
    {
        $this->equipement = $equipement;
        return $this;
    }

    public function getImageSalle(): ?string
    {
        return $this->imageSalle;
    }
    
    public function setImageSalle(?string $imageSalle): self
{
    $this->imageSalle = $imageSalle;
    return $this;
}


    

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    // Setter pour "prix"
    public function setPrix(?string $prix): self
    {
        $this->prix = $prix;
        return $this;
    }

    public function getQualite(): ?string
    {
        return $this->qualite;
    }

    // Setter pour "qualite"
    public function setQualite(?string $qualite): self
    {
        $this->qualite = $qualite;
        return $this;
    }

    public function getUser(): ?Utilisateur
    {
        return $this->user;
    }

    // Setter pour "user"
    public function setUser(?Utilisateur $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getLocationSalle(): string
    {
        return $this->locationSalle;
    }

    // Setter pour "locationSalle"
    public function setLocationSalle(string $locationSalle): self
    {
        $this->locationSalle = $locationSalle;
        return $this;
    }

 
}
