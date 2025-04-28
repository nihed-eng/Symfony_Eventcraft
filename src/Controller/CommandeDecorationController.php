<?php

namespace App\Controller;

use App\Entity\CommandeDecoration;
use App\Form\CommandeDecorationType;
use App\Repository\CommandeDecorationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Bundle\PaginatorBundle\KnpPaginatorInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use App\Repository\DecorationRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use App\Repository\UtilisateurRepository;


class CommandeDecorationController extends AbstractController
{
   
    
    #[Route('/commande/new/{idDecoration?}', name: 'app_commande_decoration_new')]
public function new(Request $request, EntityManagerInterface $entityManager, UtilisateurRepository $userRepository, DecorationRepository $decorationRepository, int $idDecoration): Response
{
    $commandeDecoration = new CommandeDecoration();

    $decoration = $decorationRepository->find($idDecoration);
    if (!$decoration) {
        throw $this->createNotFoundException("Décoration non trouvée");
    }

    $user = $this->getUser();
    if (!$user) {
        throw $this->createAccessDeniedException("Utilisateur non connecté");
    }

    $commandeDecoration->setDecoration($decoration);
    $commandeDecoration->setUser($user);

    $form = $this->createForm(CommandeDecorationType::class, $commandeDecoration);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->persist($commandeDecoration);
        $entityManager->flush();

        return $this->redirectToRoute('decoration_index'); // ou une autre route
    }

    return $this->render('commandedecoration/new.html.twig', [
        'form' => $form->createView(),
        'decoration' => $decoration,
    ]);
}


    #[Route('/decoration', name: 'decoration_index')]
public function index(
    Request $request,
    DecorationRepository $decorationRepository,
    PaginatorInterface $paginator
): Response
{
    $query = $decorationRepository->createQueryBuilder('d')
        ->orderBy('d.idDecor', 'DESC')
        ->getQuery();

    $pagination = $paginator->paginate(
        $query,
        $request->query->getInt('page', 1),
        10
    );

    return $this->render('decoration/index.html.twig', [
        'pagination' => $pagination,
    ]);
}


#[Route('/commande-decoration', name: 'commandedecoration_index', methods: ['GET'])]
public function show(
    Request $request,
    CommandeDecorationRepository $commandeRepo,
    PaginatorInterface $paginator
): Response
{
    $query = $commandeRepo->createQueryBuilder('c')
        ->leftJoin('c.decoration', 'd')
        ->addSelect('d')
        ->orderBy('c.idCommande', 'DESC')
        ->getQuery();

    $pagination = $paginator->paginate(
        $query,
        $request->query->getInt('page', 1),
        10
    );

    return $this->render('commandedecoration/index.html.twig', [
        'pagination' => $pagination
    ]);
}

   
   



    #[Route('/commandedecoration/{id}/edit', name: 'commandedecoration_edit')]
    public function edit(
        Request $request, 
        CommandeDecoration $commandeDecoration, 
        EntityManagerInterface $entityManager,
        Security $security
    ): Response {
        // Récupérer l'utilisateur connecté
        $user = $security->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour modifier une commande.');
        }
    
        $form = $this->createForm(CommandeDecorationType::class, $commandeDecoration, [
            'user' => $user
        ]);
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
    
            $this->addFlash('success', 'Commande mise à jour avec succès');
            return $this->redirectToRoute('commandedecoration_index');
        }
    
        return $this->render('commandedecoration/edit.html.twig', [
            'form' => $form->createView(),
            'commandeDecoration' => $commandeDecoration,
        ]);
    }

    #[Route('/commandedecoration/{id}/delete', name: 'commandedecoration_delete', methods: ['POST'])]
    public function delete(Request $request, CommandeDecoration $commandeDecoration, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $commandeDecoration->getIdCommande(), $request->request->get('_token'))) {
            $entityManager->remove($commandeDecoration);
            $entityManager->flush();
        }

        return $this->redirectToRoute('commandedecoration_index');
    }
}
