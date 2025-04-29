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
<<<<<<< Updated upstream

=======
use App\Repository\UtilisateurRepository;
use App\Service\PdfService;
>>>>>>> Stashed changes


class CommandeDecorationController extends AbstractController
{
   
    
    #[Route('/commandedecoration/new', name: 'commande_decoration_new')]
    public function new(Request $request, EntityManagerInterface $entityManager, Security $security): Response
    {
        $commandeDecoration = new CommandeDecoration();
        
        // Récupérer l'utilisateur connecté
        $user = $security->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour ajouter une commande.');
        }

        // Créer le formulaire et définir l'utilisateur connecté comme valeur par défaut
        $form = $this->createForm(CommandeDecorationType::class, $commandeDecoration, [
            'user' => $user // Passer l'utilisateur connecté comme option
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Sauvegarder la commande de décoration
            $entityManager->persist($commandeDecoration);
            $entityManager->flush();

            // Redirection vers la page de succès ou autre
            return $this->redirectToRoute('decoration_index');
        }

        return $this->render('commandedecoration/new.html.twig', [
            'form' => $form->createView(),
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

   
#[Route('/paimentsucess', name: 'paimentsucess_index', methods: ['GET'])]
public function paimentsucess(
    Request $request,
    CommandeDecorationRepository $commandeRepo,
    PaginatorInterface $paginator
): Response
{
    // Récupération des commandes avec les décorations associées
    $query = $commandeRepo->createQueryBuilder('c')
        ->leftJoin('c.decoration', 'd')
        ->addSelect('d')
        ->orderBy('c.idCommande', 'DESC')
        ->getQuery();

    // Pagination des résultats
    $pagination = $paginator->paginate(
        $query,
        $request->query->getInt('page', 1), // Page courante
        10 // Nombre d'éléments par page
    );

    // Rendu du template avec la variable pagination
    return $this->render('commandedecoration/sucesspaiment.html.twig', [
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
    #[Route('/commande/payer/{id}', name: 'commande_payer')]
public function payer(CommandeDecoration $commande): Response
{
    return $this->redirectToRoute('paiement_checkout', [
        'id' => $commande->getIdCommande(),
    ]);
}



#[Route('/commande/{id}/facture', name: 'commande_facture')]
public function facture(CommandeDecoration $commande, PdfService $pdfService): Response
{
    $pdfContent = $pdfService->generatePdf('invoice/invoice.html.twig', [
        'commande' => $commande,
    ]);

    return new Response($pdfContent, 200, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'attachment; filename="facture_'.$commande->getIdCommande().'.pdf"',
    ]);
}
#[Route('/ticket/{id}', name: 'commande_qr')]
public function showTicket($id, CommandeDecorationRepository $commandeDecorationRepository): Response
{
    // Recherche de la commande
    $commande = $commandeDecorationRepository->find($id);

    if (!$commande) {
        throw $this->createNotFoundException("Commande avec l'ID $id non trouvée.");
    }

    // Vérifie que les données de la commande sont correctement passées à la vue
    dump($commande); // Pour vérifier les données de la commande

    return $this->render('commandedecoration/ticket.html.twig', [
        'commande' => $commande,
    ]);
}


}
