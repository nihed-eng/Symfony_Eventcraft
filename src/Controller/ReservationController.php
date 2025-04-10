<?php

// src/Controller/SalleController.php
namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\Salle;
use App\Entity\Utilisateur;
use App\Form\ReservationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\WebpackEncoreBundle\WebpackEncoreBundle;

final class ReservationController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/reservations', name: 'app_reservation_index')]
    public function index(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request): Response
    {
        $user = $this->getUser();
    
        // Créer la requête pour récupérer les réservations de l'utilisateur connecté
        $query = $em->getRepository(Reservation::class)
            ->createQueryBuilder('r')
            ->leftJoin('r.salle', 's')
            ->addSelect('s') // Charger les salles associées
            ->leftJoin('r.user', 'u')
            ->addSelect('u'); // Charger l'utilisateur associé
    
        // Si l'utilisateur est connecté et qu'il n'est pas un administrateur
        if ($user && !$this->isGranted('ROLE_ADMIN')) {
            $query->where('r.user = :user')  // Filtrer les réservations de l'utilisateur connecté
                  ->setParameter('user', $user);
        }
    
        // Paginer les résultats
        $pagination = $paginator->paginate(
            $query->getQuery(),
            $request->query->getInt('page', 1),
            10 // Nombre d'éléments par page
        );
    
        return $this->render('reservation/index.html.twig', [
            'pagination' => $pagination
        ]);
    }
    
    
    #[Route('/new/{idSalle}', name: 'app_reservation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, Salle $salle): Response
    {
        $reservation = new Reservation();
        $reservation->setSalle($salle); // Associate the room with the reservation

        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Set the user for the reservation, assuming the user is logged in
            $reservation->setUser($this->getUser());

            // Persist and flush the reservation
            $this->entityManager->persist($reservation);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_reservation_index');
        }

        return $this->render('reservation/new.html.twig', [
            'form' => $form->createView(),
            'salle' => $salle,
        ]);
    }

    #[Route('/{idReservation}', name: 'app_reservation_show', methods: ['GET'])]
    public function show(Reservation $reservation): Response
    {
        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    #[Route('/{idReservation}/edit', name: 'app_reservation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reservation $reservation): Response
    {
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

    #[Route('/{idReservation}', name: 'app_reservation_delete', methods: ['POST'])]
    public function delete(Request $request, Reservation $reservation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getIdReservation(), $request->request->get('_token'))) {
            $this->entityManager->remove($reservation);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/ajax/reservations', name: 'ajax_reservations', methods: ['GET'])]
    public function ajaxReservations(): JsonResponse
    {
        // Récupérer l'utilisateur connecté
        $user = $this->getUser();

        if (!$user) {
            return new JsonResponse(['error' => 'Utilisateur non connecté'], Response::HTTP_UNAUTHORIZED);
        }

        // Récupérer uniquement les réservations de l'utilisateur connecté
        $reservations = $this->entityManager->getRepository(Reservation::class)->findBy(['user' => $user]);

        $data = [];
        foreach ($reservations as $reservation) {
            $data[] = [
                'id' => $reservation->getIdReservation(),
                'salle' => $reservation->getSalle()->getNomSalle(),
                'date' => $reservation->getDateDebut()->format('Y-m-d H:i'),
                'image' => '/images/' . $reservation->getSalle()->getImageSalle(), // Ajoute l'image
            ];
        }

        return new JsonResponse($data);
    }

    #[Route('/admin/reservations', name: 'app_admin_reservations')]
    public function listAll(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request): Response
    {
        $query = $em->getRepository(Reservation::class)
            ->createQueryBuilder('r')
            ->leftJoin('r.salle', 's')  // Jointure avec la salle
            ->leftJoin('r.user', 'u')   // Jointure avec l'utilisateur
            ->addSelect('s', 'u')       // Charge les relations
            ->orderBy('r.dateDebut', 'DESC')
            ->getQuery();

        $reservations = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10 // Nombre d'items par page
        );

        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservations
        ]);
    }

    #[Route('/reservations/all', name: 'app_all_reservations')]
    public function allReservations(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request): Response
    {
        $query = $em->getRepository(Reservation::class)->createQueryBuilder('r')
            ->leftJoin('r.salle', 's')
            ->leftJoin('r.user', 'u')
            ->addSelect('s', 'u')
            ->orderBy('r.dateDebut', 'DESC')
            ->getQuery();

        $reservations = $paginator->paginate($query, $request->query->getInt('page', 1), 10);

        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservations
        ]);
    }
}
