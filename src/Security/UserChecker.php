<?php

namespace App\Security;

<<<<<<< HEAD
<<<<<<< HEAD
=======
use App\Entity\Utilisateur;
=======
<<<<<<< HEAD
>>>>>>> Salles
use App\Entity\User;
=======
use App\Entity\Utilisateur;
>>>>>>> 6ab9b1d (Initial commit)
<<<<<<< HEAD
=======
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user): void
    {
<<<<<<< HEAD
<<<<<<< HEAD
=======
        if (!$user instanceof Utilisateur) {
=======
<<<<<<< HEAD
>>>>>>> Salles
        if (!$user instanceof User) {
=======
        if (!$user instanceof Utilisateur) {
>>>>>>> 6ab9b1d (Initial commit)
<<<<<<< HEAD
=======
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles
            return;
        }

        if ($user->getStatutCompte() === 'banned') {
            throw new CustomUserMessageAccountStatusException('Votre compte a été banni. Veuillez contacter l\'administrateur pour plus d\'informations.');
        }
    }

    public function checkPostAuth(UserInterface $user): void
    {
<<<<<<< HEAD
<<<<<<< HEAD
=======
        if (!$user instanceof Utilisateur) {
            return;
        }
    }
}
=======
<<<<<<< HEAD
>>>>>>> Salles
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
<<<<<<< HEAD
=======
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles
