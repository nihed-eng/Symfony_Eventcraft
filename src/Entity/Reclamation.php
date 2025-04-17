<?php

namespace App\Entity;

use App\Repository\ReclamationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ReclamationRepository::class)]
#[ORM\Table(name: 'reclamation')]
class Reclamation
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(name: 'id_reclamation', type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(name: 'titre', type: Types::STRING, length: 255)]
    #[Assert\NotBlank(message: 'The subject cannot be empty')]
    #[Assert\Length(
        min: 3,
        max: 255,
        minMessage: 'The subject must be at least {{ limit }} characters long',
        maxMessage: 'The subject cannot be longer than {{ limit }} characters'
    )]
    private ?string $titre = null;

    #[ORM\Column(name: 'description', type: Types::STRING, length: 255)]
    #[Assert\NotBlank(message: 'The description cannot be empty')]
    #[Assert\Length(
        min: 10,
        max: 255,
        minMessage: 'The description must be at least {{ limit }} characters long',
        maxMessage: 'The description cannot be longer than {{ limit }} characters'
    )]
    private ?string $description = null;

    #[ORM\Column(name: 'date', type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(name: 'statut', type: Types::STRING, length: 255)]
    private ?string $statut = null;

    #[ORM\Column(name: 'type', type: Types::STRING, length: 255)]
    #[Assert\NotBlank(message: 'Please select a complaint type')]
    #[Assert\Choice(
        choices: ['general', 'technical', 'service', 'other'],
        message: 'Choose a valid complaint type'
    )]
    private ?string $type = null;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class)]
    #[ORM\JoinColumn(name: 'id_user', referencedColumnName: 'id_user', nullable: false)]
    private ?Utilisateur $user = null;

    #[ORM\OneToOne(mappedBy: 'reclamation', targetEntity: Response::class, cascade: ['persist', 'remove'])]
    private ?Response $response = null;

    public function __construct()
    {
        $this->date = new \DateTime();
        $this->statut = 'pending';
        $this->type = 'general';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;
        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;
        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;
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

    public function getResponse(): ?Response
    {
        return $this->response;
    }

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

        $this->response = $response;
        return $this;
    }
}
