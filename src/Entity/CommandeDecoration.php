<?php

namespace App\Entity;

use App\Repository\CommandeDecorationRepository;
use Symfony\Component\Validator\Constraints as Assert;


use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeDecorationRepository::class)]
class CommandeDecoration

{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(name: 'id_commande', type: 'integer')]
    private int $idCommande;

    #[ORM\Column(name: 'quantité', type: 'integer')]
    #[Assert\NotBlank(message: 'La quantité est requise.')]
    #[Assert\GreaterThanOrEqual(
        value: 1,
        message: 'La quantité doit être au moins égale à 1.'
    )]    private int $quantite;

    #[ORM\Column(name: 'prix', type: 'float', precision: 10, scale: 2)]
    private float $prix;

    #[ORM\Column(name: 'date_commande', type: 'date', nullable: true)]
    #[Assert\NotBlank(message: 'La date de commande est requise.')]
#[Assert\GreaterThanOrEqual('today', message: 'La date de commande doit être aujourd\'hui ou dans le futur.')]
    private ?\DateTimeInterface $dateCommande = null;

    #[ORM\ManyToOne(targetEntity: Decoration::class)]
    #[ORM\JoinColumn(name: 'decoration', referencedColumnName: 'id_decor')]
    private ?Decoration $decoration = null;
  
    #[ORM\ManyToOne(targetEntity: Utilisateur::class)]
    #[ORM\JoinColumn(name: 'id_user', referencedColumnName: 'id')]
    private ?Utilisateur $user;
    // --- Getters and Setters ---




    
    public function getIdCommande(): int
    {
        return $this->idCommande; 
    }

    public function getQuantite(): int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;
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

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->dateCommande;
    }

    public function setDateCommande(?\DateTimeInterface $dateCommande): self
    {
        $this->dateCommande = $dateCommande;
        return $this;
    }

 

    public function getDecoration(): ?Decoration
    {
        return $this->decoration;
    }

    public function setDecoration(?Decoration $decoration): self
    {
        $this->decoration = $decoration;
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

}