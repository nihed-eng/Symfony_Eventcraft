<?php

namespace App\Entity;

use App\Repository\ResponseRepository;
<<<<<<< HEAD
use Doctrine\DBAL\Types\Types;
=======
<<<<<<< HEAD
=======
use Doctrine\DBAL\Types\Types;
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResponseRepository::class)]
#[ORM\Table(name: 'reponse')]
class Response
{
    #[ORM\Id]
<<<<<<< HEAD
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(name: 'id_reponse', type: Types::INTEGER)]
    private ?int $id = null;

=======
<<<<<<< HEAD
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'response', targetEntity: Reclamation::class)]
    #[ORM\JoinColumn(name: 'reclamation_id', referencedColumnName: 'id')]
=======
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(name: 'id_reponse', type: Types::INTEGER)]
    private ?int $id = null;

>>>>>>> c139a4e (Résolution des conflits)
    #[ORM\Column(name: 'contenu_reponse', type: Types::STRING, length: 255)]
    private ?string $contenu = null;

    #[ORM\OneToOne(inversedBy: 'response')]
    #[ORM\JoinColumn(name: 'reclamation_id', referencedColumnName: 'id_reclamation', nullable: false)]
<<<<<<< HEAD
=======
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)
    private ?Reclamation $reclamation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

<<<<<<< HEAD
    public function setContenu(string $contenu): self
=======
<<<<<<< HEAD
    public function setContenu(string $contenu): static
=======
    public function setContenu(string $contenu): self
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)
    {
        $this->contenu = $contenu;
        return $this;
    }

    public function getReclamation(): ?Reclamation
    {
        return $this->reclamation;
    }

<<<<<<< HEAD
    public function setReclamation(Reclamation $reclamation): self
=======
<<<<<<< HEAD
    public function setReclamation(Reclamation $reclamation): static
=======
    public function setReclamation(Reclamation $reclamation): self
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)
    {
        $this->reclamation = $reclamation;
        return $this;
    }
}
