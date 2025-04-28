<?php

namespace App\Entity;

use App\Repository\ResetPasswordRequestRepository;
use Doctrine\ORM\Mapping as ORM;
<<<<<<< HEAD

#[ORM\Entity(repositoryClass: ResetPasswordRequestRepository::class)]
class ResetPasswordRequest
{
=======
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordRequestInterface;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordRequestTrait;

#[ORM\Entity(repositoryClass: ResetPasswordRequestRepository::class)]
class ResetPasswordRequest implements ResetPasswordRequestInterface
{
    use ResetPasswordRequestTrait;

>>>>>>> 6ab9b1d (Initial commit)
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

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
    }

    public function getId(): ?int
    {
        return $this->id;
    }

<<<<<<< HEAD
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
}