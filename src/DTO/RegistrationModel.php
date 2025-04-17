<?php

namespace App\DTO;

use App\Entity\Utilisateur;

class RegistrationModel
{
    private Utilisateur $user;
    private RegistrationDTO $dto;

    public function __construct()
    {
        $this->user = new Utilisateur();
        $this->dto = new RegistrationDTO();
    }

    public function getUser(): Utilisateur
    {
        return $this->user;
    }

    public function setUser(Utilisateur $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getDto(): RegistrationDTO
    {
        return $this->dto;
    }

    public function setDto(RegistrationDTO $dto): self
    {
        $this->dto = $dto;
        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->user->getPrenom();
    }

    public function setPrenom(string $prenom): self
    {
        $this->user->setPrenom($prenom);
        return $this;
    }

    public function getNom(): ?string
    {
        return $this->user->getNom();
    }

    public function setNom(string $nom): self
    {
        $this->user->setNom($nom);
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->user->getEmail();
    }

    public function setEmail(string $email): self
    {
        $this->user->setEmail($email);
        return $this;
    }
}