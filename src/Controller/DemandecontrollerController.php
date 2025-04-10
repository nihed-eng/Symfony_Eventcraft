<?php

namespace App\Controller;

use App\Entity\Demande;
use App\Form\DemandeType;
use App\Repository\DemandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\SecurityBundle\Security;
use App\Repository\OffreRepository;

#[Route('/demande')]
final class DemandecontrollerController extends AbstractController
{
    #[Route(name: 'app_demande_index', methods: ['GET'])]
    public function index(DemandeRepository $demandeRepository): Response
    {
        return $this->render('demande/index.html.twig', [
            'demandes' => $demandeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_demande_new')]
    public function new(
        EntityManagerInterface $entityManager,
        Security $security,
        Request $request
    ): Response {
        $user = $security->getUser();
    
        $demande = new Demande();
        $form = $this->createForm(DemandeType::class, $demande);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $demande->setUser($user);
            $demande->setDateDemande(new \DateTime());
            $demande->setStatutDemande('En attente');
    
            $entityManager->persist($demande);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_demande_index');
        }
    
        return $this->render('demande/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    


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
    }
}
