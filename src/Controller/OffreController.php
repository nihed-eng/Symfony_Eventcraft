<?php

namespace App\Controller;

use App\Entity\Offre;
use App\Entity\Demande;
use App\Form\OffreType;
use App\Form\DemandeType;
use App\Repository\DemandeRepository;
use App\Repository\OffreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/offre')]
class OffreController extends AbstractController
{
    #[Route('/', name: 'app_offre_index', methods: ['GET'])]
    public function index(
        OffreRepository $offreRepository,
        Request $request,
        PaginatorInterface $paginator
    ): Response {
        $query = $offreRepository->createQueryBuilder('o')
            ->orderBy('o.dateExp', 'ASC')
            ->getQuery();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            8
        );

        return $this->render('offre/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route('/new', name: 'app_offre_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $offre = new Offre();
        $form = $this->createForm(OffreType::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($offre);
            $em->flush();

            return $this->redirectToRoute('app_offre_index');
        }

        return $this->render('offre/new.html.twig', [
            'offre' => $offre,
            'form'  => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_offre_show', methods: ['GET'])]
    public function show(Offre $offre): Response
    {
        return $this->render('offre/show.html.twig', [
            'offre' => $offre,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_offre_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Offre $offre, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(OffreType::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('app_offre_index');
        }

        return $this->render('offre/edit.html.twig', [
            'offre' => $offre,
            'form'  => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_offre_delete', methods: ['POST'])]
    public function delete(Request $request, Offre $offre, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$offre->getIdOffre(), $request->request->get('_token'))) {
            $em->remove($offre);
            $em->flush();
        }

        return $this->redirectToRoute('app_offre_index');
    }

    #[Route('/{id}/demandes', name: 'app_offre_demandes', methods: ['GET'])]
    public function showDemandes(Offre $offre, DemandeRepository $demandeRepo): Response
    {
        $demandes = $demandeRepo->findBy(['offre' => $offre]);
        return $this->render('demande/demandes_par_offre.html.twig', [
            'offre'    => $offre,
            'demandes' => $demandes,
        ]);
    }

    #[Route('/{id}/apply', name: 'app_offre_apply', methods: ['GET', 'POST'])]
    public function apply(
        Request $request,
        Offre $offre,
        EntityManagerInterface $em
    ): Response {
        $demande = new Demande();
        $demande->setOffre($offre);
        // Optional: $demande->setUtilisateur($this->getUser());
    
        $form = $this->createForm(DemandeType::class, $demande);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($demande);
            $em->flush();
    
            $this->addFlash('success', 'Votre demande a bien été envoyée !');
            return $this->redirectToRoute('app_offre_show', [
                'id' => $offre->getIdOffre(),
            ]);
        }
    
        return $this->render('demande/apply.html.twig', [
            'offre' => $offre,
            'form'  => $form->createView(),
        ]);
    }
    
}
