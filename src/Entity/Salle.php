<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'salle')]
class Salle
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(name: 'id_salle', type: 'integer')]
    private int $idSalle;

    #[ORM\Column(name: 'nom_salle', type: 'string', length: 255)]
    private string $nomSalle;

    #[ORM\Column(name: 'capacité', type: 'string', length: 255)]
    private string $capacite;

    #[ORM\Column(name: 'équipement', type: 'string', length: 255)]
    private string $equipement;

    #[ORM\Column(name: 'image_salle', type: 'string', length: 255)]
    private ?string $imageSalle = null; 

    #[ORM\Column(name: 'location_salle', type: 'string', length: 255)]
    private string $locationSalle;

    #[ORM\Column(name: 'qualite', type: 'string', length: 255, nullable: true)]
    private ?string $qualite;

    #[ORM\Column(name: 'prix', type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private ?string $prix;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private ?Utilisateur $user;

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
