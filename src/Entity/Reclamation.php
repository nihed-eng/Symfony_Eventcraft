<?php

namespace App\Entity;

use App\Repository\ReclamationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReclamationRepository::class)]
<<<<<<< HEAD
<<<<<<< HEAD
class Reclamation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id_user = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 255)]
    private ?string $statut = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class, inversedBy: 'reclamations')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private ?Utilisateur $user = null;

=======
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
>>>>>>> Salles
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
<<<<<<< HEAD
=======
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles
    private ?Response $response = null;

    public function __construct()
    {
        $this->date = new \DateTime();
<<<<<<< HEAD
<<<<<<< HEAD
=======
        $this->statut = 'pending';
        $this->type = 'general';
=======
<<<<<<< HEAD
>>>>>>> Salles
=======
        $this->statut = 'pending';
        $this->type = 'general';
>>>>>>> 6ab9b1d (Initial commit)
<<<<<<< HEAD
=======
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles
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
<<<<<<< HEAD
=======
    public function setTitre(string $titre): self
=======
<<<<<<< HEAD
>>>>>>> Salles
    public function setTitre(string $titre): static
=======
    public function setTitre(string $titre): self
>>>>>>> 6ab9b1d (Initial commit)
<<<<<<< HEAD
=======
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles
    {
        $this->titre = $titre;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

<<<<<<< HEAD
<<<<<<< HEAD
=======
    public function setDescription(string $description): self
=======
<<<<<<< HEAD
>>>>>>> Salles
    public function setDescription(string $description): static
=======
    public function setDescription(string $description): self
>>>>>>> 6ab9b1d (Initial commit)
<<<<<<< HEAD
=======
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles
    {
        $this->description = $description;
        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

<<<<<<< HEAD
<<<<<<< HEAD
=======
    public function setDate(\DateTimeInterface $date): self
=======
<<<<<<< HEAD
>>>>>>> Salles
    public function setDate(\DateTimeInterface $date): static
=======
    public function setDate(\DateTimeInterface $date): self
>>>>>>> 6ab9b1d (Initial commit)
<<<<<<< HEAD
=======
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles
    {
        $this->date = $date;
        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

<<<<<<< HEAD
<<<<<<< HEAD
=======
    public function setStatut(string $statut): self
=======
<<<<<<< HEAD
>>>>>>> Salles
    public function setStatut(string $statut): static
=======
    public function setStatut(string $statut): self
>>>>>>> 6ab9b1d (Initial commit)
<<<<<<< HEAD
=======
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles
    {
        $this->statut = $statut;
        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

<<<<<<< HEAD
<<<<<<< HEAD
=======
    public function setType(string $type): self
=======
<<<<<<< HEAD
>>>>>>> Salles
    public function setType(string $type): static
=======
    public function setType(string $type): self
>>>>>>> 6ab9b1d (Initial commit)
<<<<<<< HEAD
=======
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles
    {
        $this->type = $type;
        return $this;
    }

    public function getUser(): ?Utilisateur
    {
        return $this->user;
    }

<<<<<<< HEAD
<<<<<<< HEAD
=======
    public function setUser(?Utilisateur $user): self
=======
<<<<<<< HEAD
>>>>>>> Salles
    public function setUser(?Utilisateur $user): static
=======
    public function setUser(?Utilisateur $user): self
>>>>>>> 6ab9b1d (Initial commit)
<<<<<<< HEAD
=======
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles
    {
        $this->user = $user;
        return $this;
    }

    public function getResponse(): ?Response
    {
        return $this->response;
    }

<<<<<<< HEAD
<<<<<<< HEAD
    public function setResponse(?Response $response): static
    {
        if ($response === null && $this->response !== null) {
            $this->response->setReclamation(null);
        }
        if ($response !== null && $response->getReclamation() !== $this) {
            $response->setReclamation($this);
        }
=======
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
>>>>>>> Salles
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
<<<<<<< HEAD
=======
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles
        $this->response = $response;
        return $this;
    }
}
