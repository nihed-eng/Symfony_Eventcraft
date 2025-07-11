<?php

namespace App\Controller;

use App\Entity\Offre;
<<<<<<< HEAD
use App\Entity\Demande;
=======
<<<<<<< HEAD
>>>>>>> c139a4e (Résolution des conflits)
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
<<<<<<< HEAD
            'pagination' => $pagination,
=======
            'offres' => $offreRepository->findAll(),
=======
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
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)
        ]);
    }

    #[Route('/new', name: 'app_offre_new', methods: ['GET', 'POST'])]
<<<<<<< HEAD
    public function new(Request $request, EntityManagerInterface $em): Response
=======
<<<<<<< HEAD
    public function new(Request $request, EntityManagerInterface $entityManager): Response
=======
    public function new(Request $request, EntityManagerInterface $em): Response
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)
    {
        $offre = new Offre();
        $form = $this->createForm(OffreType::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
<<<<<<< HEAD
            $em->persist($offre);
            $em->flush();

            return $this->redirectToRoute('app_offre_index');
=======
<<<<<<< HEAD
            $entityManager->persist($offre);
            $entityManager->flush();

            return $this->redirectToRoute('app_offre_index', [], Response::HTTP_SEE_OTHER);
=======
            $em->persist($offre);
            $em->flush();

            return $this->redirectToRoute('app_offre_index');
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)
        }

        return $this->render('offre/new.html.twig', [
            'offre' => $offre,
<<<<<<< HEAD
            'form'  => $form->createView(),
=======
<<<<<<< HEAD
            'form' => $form,
=======
            'form'  => $form->createView(),
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)
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
<<<<<<< HEAD
    public function edit(Request $request, Offre $offre, EntityManagerInterface $em): Response
=======
<<<<<<< HEAD
    public function edit(Request $request, Offre $offre, EntityManagerInterface $entityManager): Response
=======
    public function edit(Request $request, Offre $offre, EntityManagerInterface $em): Response
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)
    {
        $form = $this->createForm(OffreType::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
<<<<<<< HEAD
            $em->flush();
            return $this->redirectToRoute('app_offre_index');
=======
<<<<<<< HEAD
            $entityManager->flush();

            return $this->redirectToRoute('app_offre_index', [], Response::HTTP_SEE_OTHER);
=======
            $em->flush();
            return $this->redirectToRoute('app_offre_index');
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)
        }

        return $this->render('offre/edit.html.twig', [
            'offre' => $offre,
<<<<<<< HEAD
            'form'  => $form->createView(),
=======
<<<<<<< HEAD
            'form' => $form,
=======
            'form'  => $form->createView(),
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)
        ]);
    }

    #[Route('/{id}', name: 'app_offre_delete', methods: ['POST'])]
<<<<<<< HEAD
    public function delete(Request $request, Offre $offre, EntityManagerInterface $em): Response
=======
<<<<<<< HEAD
    public function delete(Request $request, Offre $offre, EntityManagerInterface $entityManager): Response
>>>>>>> c139a4e (Résolution des conflits)
    {
        if ($this->isCsrfTokenValid('delete'.$offre->getIdOffre(), $request->request->get('_token'))) {
            $em->remove($offre);
            $em->flush();
        }

        return $this->redirectToRoute('app_offre_index');
    }
<<<<<<< HEAD
=======
}
=======
    public function delete(Request $request, Offre $offre, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$offre->getIdOffre(), $request->request->get('_token'))) {
            $em->remove($offre);
            $em->flush();
        }

        return $this->redirectToRoute('app_offre_index');
    }
>>>>>>> c139a4e (Résolution des conflits)

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
<<<<<<< HEAD
=======
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)
