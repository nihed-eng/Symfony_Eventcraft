<?php

namespace App\Entity;

use App\Repository\ReclamationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReclamationRepository::class)]
<<<<<<< HEAD
#[ORM\Table(name: 'reclamation')]
=======
<<<<<<< HEAD
>>>>>>> c139a4e (Résolution des conflits)
class Reclamation
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(name: 'id_reclamation', type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(name: 'titre', type: Types::STRING, length: 255)]
    private ?string $titre = null;

    #[ORM\Column(name: 'description', type: Types::STRING, length: 255)]
    private ?string $description = null;

    #[ORM\Column(name: 'date', type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(name: 'statut', type: Types::STRING, length: 255)]
    private ?string $statut = null;

    #[ORM\Column(name: 'type', type: Types::STRING, length: 255)]
    private ?string $type = null;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class)]
    #[ORM\JoinColumn(name: 'id_user', referencedColumnName: 'id', nullable: false)]
    private ?Utilisateur $user = null;

<<<<<<< HEAD
    #[ORM\OneToOne(mappedBy: 'reclamation', targetEntity: Response::class, cascade: ['persist', 'remove'])]
=======
    #[ORM\OneToOne(mappedBy: 'reclamation', targetEntity: Response::class)]
=======
#[ORM\Table(name: 'reclamation')]
class Reclamation
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(name: 'id_reclamation', type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(name: 'titre', type: Types::STRING, length: 255)]
    private ?string $titre = null;

    #[ORM\Column(name: 'description', type: Types::STRING, length: 255)]
    private ?string $description = null;

    #[ORM\Column(name: 'date', type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(name: 'statut', type: Types::STRING, length: 255)]
    private ?string $statut = null;

    #[ORM\Column(name: 'type', type: Types::STRING, length: 255)]
    private ?string $type = null;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class)]
    #[ORM\JoinColumn(name: 'id_user', referencedColumnName: 'id', nullable: false)]
    private ?Utilisateur $user = null;

    #[ORM\OneToOne(mappedBy: 'reclamation', targetEntity: Response::class, cascade: ['persist', 'remove'])]
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)
    private ?Response $response = null;

    public function __construct()
    {
        $this->date = new \DateTime();
<<<<<<< HEAD
        $this->statut = 'pending';
        $this->type = 'general';
=======
<<<<<<< HEAD
=======
        $this->statut = 'pending';
        $this->type = 'general';
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

<<<<<<< HEAD
    public function setTitre(string $titre): self
=======
<<<<<<< HEAD
    public function setTitre(string $titre): static
=======
    public function setTitre(string $titre): self
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)
    {
        $this->titre = $titre;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

<<<<<<< HEAD
    public function setDescription(string $description): self
=======
<<<<<<< HEAD
    public function setDescription(string $description): static
=======
    public function setDescription(string $description): self
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)
    {
        $this->description = $description;
        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

<<<<<<< HEAD
    public function setDate(\DateTimeInterface $date): self
=======
<<<<<<< HEAD
    public function setDate(\DateTimeInterface $date): static
=======
    public function setDate(\DateTimeInterface $date): self
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)
    {
        $this->date = $date;
        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

<<<<<<< HEAD
    public function setStatut(string $statut): self
=======
<<<<<<< HEAD
    public function setStatut(string $statut): static
=======
    public function setStatut(string $statut): self
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)
    {
        $this->statut = $statut;
        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

<<<<<<< HEAD
    public function setType(string $type): self
=======
<<<<<<< HEAD
    public function setType(string $type): static
=======
    public function setType(string $type): self
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)
    {
        $this->type = $type;
        return $this;
    }

    public function getUser(): ?Utilisateur
    {
        return $this->user;
    }

<<<<<<< HEAD
    public function setUser(?Utilisateur $user): self
=======
<<<<<<< HEAD
    public function setUser(?Utilisateur $user): static
=======
    public function setUser(?Utilisateur $user): self
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)
    {
        $this->user = $user;
        return $this;
    }

    public function getResponse(): ?Response
    {
        return $this->response;
    }

<<<<<<< HEAD
    public function setResponse(?Response $response): self
=======
<<<<<<< HEAD
    public function setResponse(?Response $response): static
>>>>>>> c139a4e (Résolution des conflits)
    {
        // unset the owning side of the relation if necessary
        if ($response === null && $this->response !== null) {
            $this->response->setReclamation(null);
        }

        // set the owning side of the relation if necessary
        if ($response !== null && $response->getReclamation() !== $this) {
            $response->setReclamation($this);
        }
<<<<<<< HEAD

=======
=======
    public function setResponse(?Response $response): self
    {
        // unset the owning side of the relation if necessary
        if ($response === null && $this->response !== null) {
            $this->response->setReclamation(null);
        }

        // set the owning side of the relation if necessary
        if ($response !== null && $response->getReclamation() !== $this) {
            $response->setReclamation($this);
        }

>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)
        $this->response = $response;
        return $this;
    }
}
