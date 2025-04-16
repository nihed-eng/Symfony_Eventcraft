<?php

namespace App\Entity;

use App\Repository\ResponseRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResponseRepository::class)]
#[ORM\Table(name: 'reponse')]
class Response
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(name: 'id_reponse', type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(name: 'contenu_reponse', type: Types::STRING, length: 255)]
    private ?string $contenu = null;

    #[ORM\OneToOne(inversedBy: 'response')]
    #[ORM\JoinColumn(name: 'reclamation_id', referencedColumnName: 'id_reclamation', nullable: false)]
    private ?Reclamation $reclamation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;
        return $this;
    }

    public function getReclamation(): ?Reclamation
    {
        return $this->reclamation;
    }

    public function setReclamation(Reclamation $reclamation): self
    {
        $this->reclamation = $reclamation;
        return $this;
    }
}
