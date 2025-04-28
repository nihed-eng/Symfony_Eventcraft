<?php

namespace App\Controller;

<<<<<<< HEAD
use App\Entity\Demande;
use App\Form\DemandeType;
=======
use App\Entity\Offre;
use App\Form\DemandeType;
use App\Entity\Demande;
>>>>>>> 6ab9b1d (Initial commit)
use App\Repository\DemandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
<<<<<<< HEAD
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\SecurityBundle\Security;
use App\Repository\OffreRepository;
=======
use Symfony\Component\Routing\Annotation\Route;
>>>>>>> 6ab9b1d (Initial commit)

#[Route('/demande')]
final class DemandecontrollerController extends AbstractController
{
<<<<<<< HEAD
    #[Route(name: 'app_demande_index', methods: ['GET'])]
=======
    #[Route('/', name: 'app_demande_index', methods: ['GET'])]
>>>>>>> 6ab9b1d (Initial commit)
    public function index(DemandeRepository $demandeRepository): Response
    {
        return $this->render('demande/index.html.twig', [
            'demandes' => $demandeRepository->findAll(),
        ]);
    }

<<<<<<< HEAD
    #[Route('/new', name: 'app_demande_new')]
    public function new(
        EntityManagerInterface $entityManager,
        Security $security,
        Request $request
    ): Response {
        $user = $security->getUser();
    
        $demande = new Demande();
=======
    #[Route('/demande/new/{offreId}', name: 'app_demande_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, int $offreId): Response
    {
        // Fetch the Offre entity using the provided ID
        $offre = $entityManager->getRepository(Offre::class)->find($offreId);

        if (!$offre) {
            // Redirect or show error if no offer found
            $this->addFlash('error', 'Offre non trouvée');
            return $this->redirectToRoute('app_offre_index');
        }

        // Create new Demande and associate it with the Offer
        $demande = new Demande();
        $demande->setOffre($offre);

        // Create the form
        $form = $this->createForm(DemandeType::class, $demande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Save the new Demande
            $entityManager->persist($demande);
            $entityManager->flush();

            // Add a flash message to notify user of successful application
            $this->addFlash('success', 'Votre demande a été envoyée avec succès.');

            // Redirect to the Offre show page or other desired route
            return $this->redirectToRoute('app_offre_show', ['id' => $offre->getId()]);
        }

        return $this->render('demande/new.html.twig', [
            'form' => $form->createView(),
            'offre' => $offre
        ]);
    }

    #[Route('/{idDemande}', name: 'app_demande_show', methods: ['GET'])]
    public function show(Demande $demande): Response
    {
        // Get the associated 'Offre' from the 'Demande' entity
    $offre = $demande->getOffre();

        return $this->render('demande/show.html.twig', [
            'demande' => $demande,
            'offre' => $offre,  // Pass the 'offre' to the template

        ]);
    }

    #[Route('/{idDemande}/edit', name: 'app_demande_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Demande $demande, EntityManagerInterface $entityManager): Response
    {
        // Save the previous 'offre' for redirection later
        $offre = $demande->getOffre();
    
>>>>>>> 6ab9b1d (Initial commit)
        $form = $this->createForm(DemandeType::class, $demande);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
<<<<<<< HEAD
            $demande->setUser($user);
            $demande->setDateDemande(new \DateTime());
            $demande->setStatutDemande('En attente');
    
            $entityManager->persist($demande);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_demande_index');
        }
    
        return $this->render('demande/new.html.twig', [
=======
            $entityManager->flush();
    
            // Add a flash message to notify user of successful modification
            $this->addFlash('success', 'Votre demande a été modifiée avec succès.');
    
            // Redirect to the list of demandes for the current offer
            return $this->redirectToRoute('app_offre_demandes', ['id' => $offre->getIdOffre()]);
        }
    
        return $this->render('demande/edit.html.twig', [
            'demande' => $demande,
>>>>>>> 6ab9b1d (Initial commit)
            'form' => $form->createView(),
        ]);
    }
    

<<<<<<< HEAD

    #[Route('/{idDemande}', name: 'app_demande_show', methods: ['GET'])]
    public function show(Demande $demande): Response
    {
        return $this->render('demande/show.html.twig', [
            'demande' => $demande,
        ]);
    }

    #[Route('/{idDemande}/edit', name: 'app_demande_edit', methods: ['GET', 'POST'])]
public function edit(Request $request, Demande $demande, EntityManagerInterface $entityManager): Response
{
    $form = $this->createForm(DemandeType::class, $demande);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Ensure the user field remains unchanged
        $entityManager->persist($demande);
        $entityManager->flush();

        return $this->redirectToRoute('app_demande_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->render('demande/edit.html.twig', [
        'demande' => $demande,
        'form' => $form,
    ]);
}


    #[Route('/{idDemande}', name: 'app_demande_delete', methods: ['POST'])]
    public function delete(Request $request, Demande $demande, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$demande->getIdDemande(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($demande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_demande_index', [], Response::HTTP_SEE_OTHER);
=======
    #[Route('/{idDemande}', name: 'app_demande_delete', methods: ['POST'])]
    public function delete(Request $request, Demande $demande, EntityManagerInterface $entityManager): Response
    
    {
        // Get the associated 'Offre' from the 'Demande' entity
        $offre = $demande->getOffre();
    
        // Validate the CSRF token
        if ($this->isCsrfTokenValid('delete' . $demande->getIdDemande(), $request->request->get('_token'))) {
            // Remove the Demande entity
            $entityManager->remove($demande);
            $entityManager->flush();
    
            // Add a flash message indicating success
            $this->addFlash('success', 'Demande supprimée avec succès.');
        }
    
        // Redirect to the demandes page for the associated offer
        return $this->redirectToRoute('app_offre_demandes', ['id' => $offre->getIdOffre()]);
    }
    

    #[Route('/offre/{id}/demandes', name: 'app_offre_demandes')]
    public function demandesParOffre(Offre $offre, DemandeRepository $demandeRepository): Response
    {
        $demandes = $demandeRepository->findBy(['offre' => $offre]);

        return $this->render('demande/demandes_par_offre.html.twig', [
            'demandes' => $demandes,
            'offre' => $offre,
        ]);
>>>>>>> 6ab9b1d (Initial commit)
    }
}
