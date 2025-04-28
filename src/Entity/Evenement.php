<?php

namespace App\Entity;

<<<<<<< HEAD
use Doctrine\ORM\Mapping as ORM;

/**
 * Evenement
 *
 * @ORM\Table(name="evenement", indexes={@ORM\Index(name="fk_evenement_utilisateur", columns={"user"}), @ORM\Index(name="fk_evenement_salle", columns={"salle_id"})})
 * @ORM\Entity
 */
class Evenement
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_evenement", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idEvenement;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255, nullable=false)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="description_evenement", type="string", length=255, nullable=false)
     */
    private $descriptionEvenement;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=false)
     */
    private $image;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_debut", type="date", nullable=false)
     */
    private $dateDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fin", type="date", nullable=false)
     */
    private $dateFin;

    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string", length=255, nullable=false)
     */
    private $location;

    /**
     * @var \Salle
     *
     * @ORM\ManyToOne(targetEntity="Salle")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="salle_id", referencedColumnName="id_salle")
     * })
     */
    private $salle;

    /**
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user", referencedColumnName="id_user")
     * })
     */
    private $user;


}
=======
use App\Repository\EvenementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EvenementRepository::class)]
class Evenement
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "id_evenement", type: "integer")]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    #[Assert\NotBlank(message: "The title cannot be blank")]
    #[Assert\Length(max: 30, maxMessage: "The title cannot be longer than {{ limit }} characters")]
    private ?string $titre = 'My Event Title';

    #[ORM\Column(length: 30)]
    #[Assert\NotBlank(message: "The description cannot be blank")]
    #[Assert\Length(max: 30, maxMessage: "The description cannot be longer than {{ limit }} characters")]
    private ?string $descriptionEvenement = 'Event description here';

    #[ORM\Column(length: 10)]
    private ?string $image = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message: "Please provide a start date")]
    #[Assert\DateTime(format: 'Y-m-d', message: "This value is not a valid date format (YYYY-MM-DD)")]
    private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message: "La date de fin est obligatoire")]
    #[Assert\Type("\DateTimeInterface", message: "La date de fin doit être une date valide")]
    #[Assert\GreaterThanOrEqual(
        propertyPath: "dateDebut",
    message: "La date de fin doit être postérieure ou égale à la date de début"
)]
private ?\DateTimeInterface $dateFin = null;
    #[ORM\Column(length: 20)]
    #[Assert\NotBlank(message: "Please provide a location")]
    #[Assert\Length(max: 20, maxMessage: "Location cannot be longer than {{ limit }} characters")]
    private ?string $location = 'Paris, France';

    #[ORM\Column]
    private ?int $user = null;

    #[ORM\Column(nullable: true)] // Définit explicitement le champ comme nullable
    private ?int $salleId = null;

    /**
     * @var Collection<int, Participation>
     */
    #[ORM\OneToMany(targetEntity: Participation::class, mappedBy: 'evenement')]
    private Collection $participations;

    public function __construct()
    {
        $this->participations = new ArrayCollection(); // Fixed initialization
    } // Toujours initialisé à null

    // Getters et Setters
    

    public function getid(): ?int
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

    public function getDescriptionEvenement(): ?string
    {
        return $this->descriptionEvenement;
    }

    public function setDescriptionEvenement(string $descriptionEvenement): self
    {
        $this->descriptionEvenement = $descriptionEvenement;
        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;
        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): static
    {
        $this->dateDebut = $dateDebut;
        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }
    public function setDateFin(?\DateTimeInterface $dateFin): static
    {
        $this->dateFin = $dateFin;
        return $this;
    }


    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;
        return $this;
    }

    public function getUser(): ?int
    {
        return $this->user;
    }

    public function setUser(int $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getSalleId(): ?int
    {
        return null;
    }

    public function setSalleId(int $salleId): self
    {
        $this->salleId = null;
        return $this;
    }

    // Méthode magique __call pour gérer les accès aux propriétés
    public function __call(string $name, array $arguments)
    {
        if (str_starts_with($name, 'get')) {
            $property = lcfirst(substr($name, 3));
            if (property_exists($this, $property)) {
                return $this->$property;
            }
        }
        
        throw new \BadMethodCallException(sprintf('Method %s::%s does not exist.', self::class, $name));
    }

    /**
     * @return Collection<int, Participation>
     */
    public function getPaticipations(): Collection
    {
        return $this->participations;
    }

    public function addPaticipation(Participation $paticipation): static
    {
        if (!$this->participations->contains($paticipation)) {
            $this->participations->add($paticipation);
            $paticipation->setEvenement($this);
        }

        return $this;
    }

    public function removePaticipation(Participation $paticipation): static
    {
        if ($this->participations->removeElement($paticipation)) {
            // set the owning side to null (unless already changed)
            if ($paticipation->getEvenement() === $this) {
                $paticipation->setEvenement(null);
            }
        }

        return $this;
    }


    public function __toString(): string
    {
        return $this->titre ?? 'Untitled Event'; // Returns the event title or a fallback
    }
}
>>>>>>> 6ab9b1d (Initial commit)
