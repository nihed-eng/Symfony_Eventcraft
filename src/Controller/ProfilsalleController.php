<?php

// src/Controller/ProfileSalleController.php

namespace App\Controller;

use App\Entity\Salle;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
class ProfilsalleController extends AbstractController
{
    #[Route('/profilesalle', name: 'app_profilsalle')]
public function index(EntityManagerInterface $entityManager, PaginatorInterface $paginator, Request $request): Response
{
    $user = $this->getUser();

    if ($user) {
        $query = $entityManager->getRepository(Salle::class)->createQueryBuilder('s')
            ->where('s.user = :user')
            ->setParameter('user', $user)
            ->getQuery();
    } else {
        $query = [];
    }

    $pagination = $paginator->paginate(
        $query,
        $request->query->getInt('page', 1),
        3
    );

    return $this->render('profilesalle/profilsalle.html.twig', [
        'pagination' => $pagination,
    ]);
}
}

