<?php

// src/Controller/SalleController.php
namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\Salle;
use App\Entity\Utilisateur;
use App\Form\ReservationType;
<<<<<<< HEAD
use App\Service\PdfGenerator;
=======
<<<<<<< HEAD
=======
use App\Service\PdfGenerator;
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)
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
    
        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder à vos réservations.');
        }
    
        $queryBuilder = $em->getRepository(Reservation::class)
            ->createQueryBuilder('r')
            ->leftJoin('r.salle', 's')
            ->addSelect('s')
            ->leftJoin('r.user', 'u')
            ->addSelect('u')
            ->where('r.user = :user')
            ->setParameter('user', $user)
            ->orderBy('r.dateDebut', 'DESC'); // Tri par date de début décroissante
    
        $pagination = $paginator->paginate(
            $queryBuilder->getQuery(),
            $request->query->getInt('page', 1),
            10 // Nombre d'éléments par page
        );
    
        return $this->render('reservation/index.html.twig', [
            'pagination' => $pagination
        ]);
    }
    
    
    #[Route('/new/{idSalle}', name: 'app_reservation_new', methods: ['GET', 'POST'])]
<<<<<<< HEAD
    public function new(Request $request, Salle $salle, EntityManagerInterface $entityManager): Response
=======
<<<<<<< HEAD
    public function new(Request $request, Salle $salle): Response
>>>>>>> c139a4e (Résolution des conflits)
    {
        $reservation = new Reservation();
        $reservation->setSalle($salle);
    
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);
    
        if ($form->isSubmitted()) {
            // Validation manuelle supplémentaire
            $errors = [];
            $now = new \DateTime();
    
            if ($reservation->getDateDebut() < $now) {
                $errors[] = 'La date de début doit être dans le futur';
            }
    
            if ($reservation->getDateFin() <= $reservation->getDateDebut()) {
                $errors[] = 'La date de fin doit être supérieure à la date de début';
            }
    
            // Vérification de conflit de réservation
            $conflictingReservations = $entityManager->getRepository(Reservation::class)
            ->createQueryBuilder('r')
            ->where('r.salle = :salle')
            ->andWhere('r.dateFin > :start AND r.dateDebut < :end')
            ->setParameter('salle', $salle)
            ->setParameter('start', $reservation->getDateDebut())
            ->setParameter('end', $reservation->getDateFin())
            ->getQuery()
            ->getResult();
        
    
            if (!empty($conflictingReservations)) {
                $errors[] = 'La salle est déjà réservée pour la période sélectionnée.';
            }
    
            if (empty($errors)) {
                $reservation->setUser($this->getUser());
                $entityManager->persist($reservation);
                $entityManager->flush();
    
                $this->addFlash('success', 'Réservation créée avec succès');
                return $this->redirectToRoute('app_reservation_index');
            }
    
            foreach ($errors as $error) {
                $this->addFlash('error', $error);
            }
        }
<<<<<<< HEAD
    
=======

=======
    public function new(Request $request, Salle $salle, EntityManagerInterface $entityManager): Response
    {
        $reservation = new Reservation();
        $reservation->setSalle($salle);
    
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);
    
        if ($form->isSubmitted()) {
            // Validation manuelle supplémentaire
            $errors = [];
            $now = new \DateTime();
    
            if ($reservation->getDateDebut() < $now) {
                $errors[] = 'La date de début doit être dans le futur';
            }
    
            if ($reservation->getDateFin() <= $reservation->getDateDebut()) {
                $errors[] = 'La date de fin doit être supérieure à la date de début';
            }
    
            // Vérification de conflit de réservation
            $conflictingReservations = $entityManager->getRepository(Reservation::class)
            ->createQueryBuilder('r')
            ->where('r.salle = :salle')
            ->andWhere('r.dateFin > :start AND r.dateDebut < :end')
            ->setParameter('salle', $salle)
            ->setParameter('start', $reservation->getDateDebut())
            ->setParameter('end', $reservation->getDateFin())
            ->getQuery()
            ->getResult();
        
    
            if (!empty($conflictingReservations)) {
                $errors[] = 'La salle est déjà réservée pour la période sélectionnée.';
            }
    
            if (empty($errors)) {
                $reservation->setUser($this->getUser());
                $entityManager->persist($reservation);
                $entityManager->flush();
    
                $this->addFlash('success', 'Réservation créée avec succès');
                return $this->redirectToRoute('app_reservation_index');
            }
    
            foreach ($errors as $error) {
                $this->addFlash('error', $error);
            }
        }
    
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)
        return $this->render('reservation/new.html.twig', [
            'form' => $form->createView(),
            'salle' => $salle,
        ]);
    }
<<<<<<< HEAD
    
=======
<<<<<<< HEAD
=======
    
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)

    #[Route('/{idReservation}', name: 'app_reservation_show', methods: ['GET'])]
    public function show(Reservation $reservation): Response
    {
        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    #[Route('/{idReservation}/edit', name: 'app_reservation_edit', methods: ['GET', 'POST'])]
<<<<<<< HEAD
    public function edit(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
=======
<<<<<<< HEAD
    public function edit(Request $request, Reservation $reservation): Response
>>>>>>> c139a4e (Résolution des conflits)
    {
        // Sauvegarde des dates originales pour la vérification de conflit
        $originalDateDebut = $reservation->getDateDebut();
        $originalDateFin = $reservation->getDateFin();
        
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);
    
        if ($form->isSubmitted()) {
            $errors = [];
            $now = new \DateTime();
            $today = new \DateTime('today');
    
            // Vérification que la date de début n'est pas dans le passé
            if ($reservation->getDateDebut() < $today) {
                $errors[] = 'Vous ne pouvez pas réserver pour une date passée.';
            }
    
            // Vérification que la date de début n'est pas aujourd'hui
            if ($reservation->getDateDebut()->format('Y-m-d') === $today->format('Y-m-d')) {
                $errors[] = 'Les réservations doivent être faites au moins 24h à l\'avance.';
            }
    
            // Vérification que la date de fin est égale ou postérieure à la date de début
            if ($reservation->getDateFin() < $reservation->getDateDebut()) {
                $errors[] = 'La date de fin doit être égale ou postérieure à la date de début.';
            }
    
            // Vérification de conflit seulement si les dates ont changé
            if ($reservation->getDateDebut() != $originalDateDebut || $reservation->getDateFin() != $originalDateFin) {
                $conflictingReservations = $entityManager->getRepository(Reservation::class)
                    ->createQueryBuilder('r')
                    ->where('r.salle = :salle')
                    ->andWhere('r.idReservation != :currentReservation')
                    ->andWhere('r.dateFin > :start AND r.dateDebut < :end')
                    ->setParameter('salle', $reservation->getSalle())
                    ->setParameter('currentReservation', $reservation->getIdReservation())
                    ->setParameter('start', $reservation->getDateDebut())
                    ->setParameter('end', $reservation->getDateFin())
                    ->getQuery()
                    ->getResult();
    
                if (!empty($conflictingReservations)) {
                    $errors[] = 'La salle est déjà réservée pour cette période. Veuillez choisir d\'autres dates.';
                }
            }
    
            if (empty($errors)) {
                $entityManager->flush();
                $this->addFlash('success', 'La réservation a été modifiée avec succès.');
                return $this->redirectToRoute('app_reservation_index');
            }
    
            foreach ($errors as $error) {
                $this->addFlash('error', $error);
            }
        }
    
        return $this->render('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
        ]);
    }
<<<<<<< HEAD
    

=======
=======
    public function edit(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        // Sauvegarde des dates originales pour la vérification de conflit
        $originalDateDebut = $reservation->getDateDebut();
        $originalDateFin = $reservation->getDateFin();
        
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);
    
        if ($form->isSubmitted()) {
            $errors = [];
            $now = new \DateTime();
            $today = new \DateTime('today');
    
            // Vérification que la date de début n'est pas dans le passé
            if ($reservation->getDateDebut() < $today) {
                $errors[] = 'Vous ne pouvez pas réserver pour une date passée.';
            }
    
            // Vérification que la date de début n'est pas aujourd'hui
            if ($reservation->getDateDebut()->format('Y-m-d') === $today->format('Y-m-d')) {
                $errors[] = 'Les réservations doivent être faites au moins 24h à l\'avance.';
            }
    
            // Vérification que la date de fin est égale ou postérieure à la date de début
            if ($reservation->getDateFin() < $reservation->getDateDebut()) {
                $errors[] = 'La date de fin doit être égale ou postérieure à la date de début.';
            }
    
            // Vérification de conflit seulement si les dates ont changé
            if ($reservation->getDateDebut() != $originalDateDebut || $reservation->getDateFin() != $originalDateFin) {
                $conflictingReservations = $entityManager->getRepository(Reservation::class)
                    ->createQueryBuilder('r')
                    ->where('r.salle = :salle')
                    ->andWhere('r.idReservation != :currentReservation')
                    ->andWhere('r.dateFin > :start AND r.dateDebut < :end')
                    ->setParameter('salle', $reservation->getSalle())
                    ->setParameter('currentReservation', $reservation->getIdReservation())
                    ->setParameter('start', $reservation->getDateDebut())
                    ->setParameter('end', $reservation->getDateFin())
                    ->getQuery()
                    ->getResult();
    
                if (!empty($conflictingReservations)) {
                    $errors[] = 'La salle est déjà réservée pour cette période. Veuillez choisir d\'autres dates.';
                }
            }
    
            if (empty($errors)) {
                $entityManager->flush();
                $this->addFlash('success', 'La réservation a été modifiée avec succès.');
                return $this->redirectToRoute('app_reservation_index');
            }
    
            foreach ($errors as $error) {
                $this->addFlash('error', $error);
            }
        }
    
        return $this->render('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
        ]);
    }
    

>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)

    #[Route('/{idReservation}', name: 'app_reservation_delete', methods: ['POST'])]
    public function delete(Request $request, Reservation $reservation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getIdReservation(), $request->request->get('_token'))) {
            $this->entityManager->remove($reservation);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
    }

<<<<<<< HEAD
   
=======
<<<<<<< HEAD
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
=======
   
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)

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
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
>>>>>>> c139a4e (Résolution des conflits)




    #[Route('/reservation/{idReservation}/pdf', name: 'app_reservation_pdf')]
    public function generatePdf(Reservation $reservation, PdfGenerator $pdfService): Response
    {
        try {
            $pdf = $pdfService->generateFromTemplate(
                'reservation/pdf.html.twig',
                ['reservation' => $reservation],
                'reservation-'.$reservation->getIdReservation().'.pdf'
            );
    
            return new Response(
                $pdf,
                200,
                [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'attachment; filename="reservation-'.$reservation->getIdReservation().'.pdf"'
                ]
            );
        } catch (\Exception $e) {
            throw new \RuntimeException('PDF generation failed: '.$e->getMessage());
        }
    }
    

<<<<<<< HEAD
=======
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)
}
