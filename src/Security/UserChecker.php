<?php

namespace App\Security;

<<<<<<< HEAD
use App\Entity\Utilisateur;
=======
<<<<<<< HEAD
use App\Entity\User;
=======
use App\Entity\Utilisateur;
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user): void
    {
<<<<<<< HEAD
        if (!$user instanceof Utilisateur) {
=======
<<<<<<< HEAD
        if (!$user instanceof User) {
=======
        if (!$user instanceof Utilisateur) {
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)
            return;
        }

        if ($user->getStatutCompte() === 'banned') {
            throw new CustomUserMessageAccountStatusException('Votre compte a été banni. Veuillez contacter l\'administrateur pour plus d\'informations.');
        }
    }

    public function checkPostAuth(UserInterface $user): void
    {
<<<<<<< HEAD
        if (!$user instanceof Utilisateur) {
            return;
        }
    }
}
=======
<<<<<<< HEAD
        if (!$user instanceof User) {
            return;
        }
    }
} 
=======
        if (!$user instanceof Utilisateur) {
            return;
        }
    }
}
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)
