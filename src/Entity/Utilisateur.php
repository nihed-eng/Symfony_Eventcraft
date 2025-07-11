<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
<<<<<<< HEAD
use Doctrine\DBAL\Types\Types;
=======
<<<<<<< HEAD
=======
use Doctrine\DBAL\Types\Types;
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
#[ORM\Table(name: 'utilisateur')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
<<<<<<< HEAD
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(name: 'id', type: Types::INTEGER)]
=======
<<<<<<< HEAD
    #[ORM\GeneratedValue]
    #[ORM\Column]
>>>>>>> c139a4e (Résolution des conflits)
    private ?int $id = null;

    #[ORM\Column(length: 255, name: 'nom')]
    private ?string $nom = null;

    #[ORM\Column(length: 255, name: 'prenom')]
    private ?string $prenom = null;

    #[ORM\Column(length: 255, name: 'password')]
    private ?string $password = null;

    #[ORM\Column(length: 255, name: 'statut_compte')]
    private ?string $statut_compte = 'active';

    #[ORM\Column(length: 255, name: 'role')]
    private ?string $role = 'ROLE_USER';

    #[ORM\Column(length: 255, name: 'email')]
    private ?string $email = null;

<<<<<<< HEAD
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Reclamation::class, orphanRemoval: true)]
=======
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Reclamation::class)]
=======
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(name: 'id', type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(length: 255, name: 'nom')]
    private ?string $nom = null;

    #[ORM\Column(length: 255, name: 'prenom')]
    private ?string $prenom = null;

    #[ORM\Column(length: 255, name: 'password')]
    private ?string $password = null;

    #[ORM\Column(length: 255, name: 'statut_compte')]
    private ?string $statut_compte = 'active';

    #[ORM\Column(length: 255, name: 'role')]
    private ?string $role = 'ROLE_USER';

    #[ORM\Column(length: 255, name: 'email')]
    private ?string $email = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Reclamation::class, orphanRemoval: true)]
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)
    private Collection $reclamations;

    public function __construct()
    {
        $this->reclamations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;
        return $this;
    }

<<<<<<< HEAD
=======
<<<<<<< HEAD
    // Remove this duplicate annotation
    // #[ORM\Column(length: 255)]

=======
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)
    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    public function getStatutCompte(): ?string
    {
        return $this->statut_compte;
    }

    public function setStatutCompte(string $statut_compte): static
    {
        $this->statut_compte = $statut_compte;
        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): static
    {
        $this->role = $role;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getReclamations(): Collection
    {
        return $this->reclamations;
    }

    public function addReclamation(Reclamation $reclamation): static
    {
        if (!$this->reclamations->contains($reclamation)) {
            $this->reclamations->add($reclamation);
            $reclamation->setUser($this);
        }
        return $this;
    }

    public function removeReclamation(Reclamation $reclamation): static
    {
        if ($this->reclamations->removeElement($reclamation)) {
            if ($reclamation->getUser() === $this) {
                $reclamation->setUser(null);
            }
        }
        return $this;
    }

    public function getRoles(): array
    {
        return [$this->role];
    }

    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }
<<<<<<< HEAD
}
=======
<<<<<<< HEAD
}
=======
}
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)
