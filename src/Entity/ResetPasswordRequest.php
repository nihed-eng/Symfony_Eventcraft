<?php

namespace App\Entity;

use App\Repository\ResetPasswordRequestRepository;
use Doctrine\ORM\Mapping as ORM;
<<<<<<< HEAD
<<<<<<< HEAD

#[ORM\Entity(repositoryClass: ResetPasswordRequestRepository::class)]
class ResetPasswordRequest
{
=======
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordRequestInterface;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordRequestTrait;
=======
<<<<<<< HEAD
>>>>>>> c139a4e (Résolution des conflits)

#[ORM\Entity(repositoryClass: ResetPasswordRequestRepository::class)]
class ResetPasswordRequest implements ResetPasswordRequestInterface
{
<<<<<<< HEAD
    use ResetPasswordRequestTrait;

=======
>>>>>>> Salles
=======
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordRequestInterface;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordRequestTrait;

#[ORM\Entity(repositoryClass: ResetPasswordRequestRepository::class)]
class ResetPasswordRequest implements ResetPasswordRequestInterface
{
    use ResetPasswordRequestTrait;

>>>>>>> 6ab9b1d (Initial commit)
<<<<<<< HEAD
=======
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

<<<<<<< HEAD
<<<<<<< HEAD
    #[ORM\ManyToOne(targetEntity: Utilisateur::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private ?Utilisateur $user = null;

    #[ORM\Column(length: 6)]
    private ?string $verificationCode = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $expiresAt = null;

    #[ORM\Column]
    private ?bool $isVerified = false;

    public function __construct(Utilisateur $user)
    {
        $this->user = $user;
=======
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "id", nullable: false)]
=======
<<<<<<< HEAD
    #[ORM\ManyToOne(targetEntity: Utilisateur::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
>>>>>>> c139a4e (Résolution des conflits)
    private ?Utilisateur $user = null;

    public function __construct(Utilisateur $user, \DateTimeInterface $expiresAt, string $selector, string $hashedToken)
    {
        $this->user = $user;
<<<<<<< HEAD
        $this->initialize($expiresAt, $selector, $hashedToken);
=======
>>>>>>> Salles
        $this->verificationCode = sprintf('%06d', random_int(0, 999999));
        $this->expiresAt = new \DateTimeImmutable('+30 minutes');
        $this->isVerified = false;
=======
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "id", nullable: false)]
    private ?Utilisateur $user = null;

    public function __construct(Utilisateur $user, \DateTimeInterface $expiresAt, string $selector, string $hashedToken)
    {
        $this->user = $user;
        $this->initialize($expiresAt, $selector, $hashedToken);
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

<<<<<<< HEAD
<<<<<<< HEAD
=======
    public function getUser(): object
    {
        return $this->user;
    }
=======
<<<<<<< HEAD
>>>>>>> Salles
    public function getUser(): ?Utilisateur
    {
        return $this->user;
    }

    public function getVerificationCode(): ?string
    {
        return $this->verificationCode;
    }

    public function getExpiresAt(): ?\DateTimeImmutable
    {
        return $this->expiresAt;
    }

    public function isVerified(): ?bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;
        return $this;
    }

    public function isExpired(): bool
    {
        return $this->expiresAt <= new \DateTimeImmutable();
    }
=======
    public function getUser(): object
    {
        return $this->user;
    }
>>>>>>> 6ab9b1d (Initial commit)
<<<<<<< HEAD
=======
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles
}