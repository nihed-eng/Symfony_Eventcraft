<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class RegistrationDTO
{
    #[Assert\NotBlank(message: 'Please enter a password')]
    #[Assert\Length(
        min: 6,
        max: 4096,
        minMessage: 'Your password should be at least {{ limit }} characters',
        maxMessage: 'Your password cannot be longer than {{ limit }} characters'
    )]
    #[Assert\NotCompromisedPassword(message: 'This password has been leaked in a data breach. Please use a different password.')]
    private ?string $plainPassword = null;

    #[Assert\IsTrue(message: 'You should agree to our terms.')]
    private ?bool $agreeTerms = false;

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function getAgreeTerms(): ?bool
    {
        return $this->agreeTerms;
    }

    public function setAgreeTerms(bool $agreeTerms): self
    {
        $this->agreeTerms = $agreeTerms;

        return $this;
    }
}