<?php

namespace App\Controller\Admin;

<<<<<<< HEAD
<<<<<<< HEAD
use App\Entity\User;
use App\Entity\Reclamation;
use App\Entity\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
=======
use App\Entity\Utilisateur;
=======
<<<<<<< HEAD
use App\Entity\User;
>>>>>>> c139a4e (Résolution des conflits)
use App\Entity\Reclamation;
use App\Entity\Response as ReclamationResponse;
use App\Entity\Salle;
use App\Form\SalleType;
use App\Entity\Reservation;
use App\Repository\SalleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
<<<<<<< HEAD
=======
>>>>>>> Salles

=======
use App\Entity\Utilisateur;
use App\Entity\Reclamation;
use App\Entity\Response as ReclamationResponse;
use App\Entity\Salle;
use App\Form\SalleType;
use App\Entity\Reservation;
use App\Repository\SalleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
<<<<<<< HEAD
=======
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use App\Entity\Offre;
use App\Entity\Demande;
use App\Repository\OffreRepository;
use App\Repository\DemandeRepository;
use App\Repository\CommandeDecorationRepository;
use App\Repository\DecorationRepository;
use App\Entity\Decoration;
<<<<<<< HEAD
>>>>>>> 6ab9b1d (Initial commit)
=======
<<<<<<< HEAD
=======
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles
#[Route('/admin')]
#[IsGranted('ROLE_ADMIN')]
class AdminDashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_admin_dashboard')]
<<<<<<< HEAD
<<<<<<< HEAD
=======
    public function index(EntityManagerInterface $entityManager): Response
    {
        $users = $entityManager->getRepository(Utilisateur::class)->findAll();
        $reclamations = $entityManager->getRepository(Reclamation::class)->findBy([], ['date' => 'DESC']);
=======
<<<<<<< HEAD
>>>>>>> Salles
    public function index(EntityManagerInterface $entityManager): HttpResponse
    {
        $users = $entityManager->getRepository(User::class)->findAll();
        
        // Check if Reclamation entity and repository exist
        try {
            $reclamations = $entityManager->getRepository(Reclamation::class)->findBy([], ['createdAt' => 'DESC']);
        } catch (\Exception $e) {
            // If there's an error, set reclamations to an empty array
            $reclamations = [];
        }
=======
    public function index(EntityManagerInterface $entityManager): Response
    {
        $users = $entityManager->getRepository(Utilisateur::class)->findAll();
        $reclamations = $entityManager->getRepository(Reclamation::class)->findBy([], ['date' => 'DESC']);
>>>>>>> 6ab9b1d (Initial commit)
<<<<<<< HEAD
=======
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles

        return $this->render('admin/dashboard/index.html.twig', [
            'users' => $users,
            'reclamations' => $reclamations,
        ]);
    }

<<<<<<< HEAD
<<<<<<< HEAD
    #[Route('/users', name: 'app_admin_users')]
    public function users(EntityManagerInterface $entityManager): HttpResponse
    {
=======
    #[Route('/salles/full', name: 'app_admin_salles_full')]
    public function fullList(
        SalleRepository $salleRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $queryBuilder = $salleRepository->createQueryBuilder('s');
        
        // Filtres
        if ($search = $request->query->get('search')) {
            $queryBuilder
                ->andWhere('s.nomSalle LIKE :search OR s.locationSalle LIKE :search')
                ->setParameter('search', '%'.$search.'%');
        }
        
        if ($qualite = $request->query->get('qualite')) {
            $queryBuilder
                ->andWhere('s.qualite = :qualite')
                ->setParameter('qualite', $qualite);
        }
        
        if ($capacite = $request->query->get('capacite')) {
            $queryBuilder
                ->andWhere('s.capacite >= :capacite')
                ->setParameter('capacite', $capacite);
        }
        
        // Tri sécurisé
        $sort = in_array($request->query->get('sort'), ['s.idSalle', 's.nomSalle', 's.capacite', 's.locationSalle', 's.qualite', 's.prix']) 
            ? $request->query->get('sort') 
            : 's.idSalle';
        
        $direction = in_array(strtoupper($request->query->get('direction')), ['ASC', 'DESC']) 
            ? strtoupper($request->query->get('direction')) 
            : 'DESC';
        
        $queryBuilder->orderBy($sort, $direction);
        
        $salles = $paginator->paginate(
            $queryBuilder->getQuery(),
            $request->query->getInt('page', 1),
            10,
            [
                'defaultSortFieldName' => $sort,
                'defaultSortDirection' => $direction,
            ]
        );
        
        return $this->render('admin/dashboard/dashboardsalle.html.twig', [
            'salles' => $salles,
            'current_sort' => $sort,
            'current_direction' => $direction,
        ]);
    }

=======
<<<<<<< HEAD
>>>>>>> c139a4e (Résolution des conflits)
    #[Route('/users', name: 'app_admin_users')]
    public function users(EntityManagerInterface $entityManager): Response
    {
<<<<<<< HEAD
        $users = $entityManager->getRepository(Utilisateur::class)->findAll();
=======
>>>>>>> Salles
        $users = $entityManager->getRepository(User::class)->findAll();
=======
    #[Route('/salles/full', name: 'app_admin_salles_full')]
    public function fullList(
        SalleRepository $salleRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $queryBuilder = $salleRepository->createQueryBuilder('s');
        
        // Filtres
        if ($search = $request->query->get('search')) {
            $queryBuilder
                ->andWhere('s.nomSalle LIKE :search OR s.locationSalle LIKE :search')
                ->setParameter('search', '%'.$search.'%');
        }
        
        if ($qualite = $request->query->get('qualite')) {
            $queryBuilder
                ->andWhere('s.qualite = :qualite')
                ->setParameter('qualite', $qualite);
        }
        
        if ($capacite = $request->query->get('capacite')) {
            $queryBuilder
                ->andWhere('s.capacite >= :capacite')
                ->setParameter('capacite', $capacite);
        }
        
        // Tri sécurisé
        $sort = in_array($request->query->get('sort'), ['s.idSalle', 's.nomSalle', 's.capacite', 's.locationSalle', 's.qualite', 's.prix']) 
            ? $request->query->get('sort') 
            : 's.idSalle';
        
        $direction = in_array(strtoupper($request->query->get('direction')), ['ASC', 'DESC']) 
            ? strtoupper($request->query->get('direction')) 
            : 'DESC';
        
        $queryBuilder->orderBy($sort, $direction);
        
        $salles = $paginator->paginate(
            $queryBuilder->getQuery(),
            $request->query->getInt('page', 1),
            10,
            [
                'defaultSortFieldName' => $sort,
                'defaultSortDirection' => $direction,
            ]
        );
        
        return $this->render('admin/dashboard/dashboardsalle.html.twig', [
            'salles' => $salles,
            'current_sort' => $sort,
            'current_direction' => $direction,
        ]);
    }

    #[Route('/users', name: 'app_admin_users')]
    public function users(EntityManagerInterface $entityManager): Response
    {
        $users = $entityManager->getRepository(Utilisateur::class)->findAll();
>>>>>>> 6ab9b1d (Initial commit)
<<<<<<< HEAD
=======
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles

        return $this->render('admin/dashboard/users.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/reclamations', name: 'app_admin_reclamations')]
<<<<<<< HEAD
<<<<<<< HEAD
=======
    public function reclamations(EntityManagerInterface $entityManager): Response
    {
        $reclamations = $entityManager->getRepository(Reclamation::class)->findBy([], ['date' => 'DESC']);
=======
<<<<<<< HEAD
>>>>>>> Salles
    public function reclamations(EntityManagerInterface $entityManager): HttpResponse
    {
        $reclamations = $entityManager->getRepository(Reclamation::class)->findBy([], ['createdAt' => 'DESC']);
=======
    public function reclamations(EntityManagerInterface $entityManager): Response
    {
        $reclamations = $entityManager->getRepository(Reclamation::class)->findBy([], ['date' => 'DESC']);
>>>>>>> 6ab9b1d (Initial commit)
<<<<<<< HEAD
=======
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles

        return $this->render('admin/dashboard/reclamations.html.twig', [
            'reclamations' => $reclamations,
        ]);
    }

<<<<<<< HEAD
<<<<<<< HEAD
    #[Route('/reclamation/{id}/respond', name: 'app_admin_reclamation_respond', methods: ['POST'])]
    public function respondToReclamation(Request $request, Reclamation $reclamation, EntityManagerInterface $entityManager): HttpResponse
    {
        if (!$this->isCsrfTokenValid('respond-reclamation-' . $reclamation->getId(), $request->request->get('_token'))) {
            $this->addFlash('error', 'Token CSRF invalide.');
            return $this->redirectToRoute('app_admin_reclamations');
        }

        $responseContent = $request->request->get('response');
        if (empty($responseContent)) {
            $this->addFlash('error', 'La réponse ne peut pas être vide.');
            return $this->redirectToRoute('app_admin_reclamations');
        }

        // Check if reclamation already has a response
        if ($reclamation->getResponse() !== null) {
            $this->addFlash('error', 'Cette réclamation a déjà été traitée.');
            return $this->redirectToRoute('app_admin_reclamations');
        }

        // Create new response
        $response = new Response();
        $response->setContent($responseContent);
        $response->setRespondedBy($this->getUser());
        $response->setReclamation($reclamation);
        
        // Update reclamation status
        $reclamation->setStatus('resolved');
        
        // Persist the response
        $entityManager->persist($response);
        $entityManager->flush();

        $this->addFlash('success', 'Réponse envoyée avec succès.');
        return $this->redirectToRoute('app_admin_reclamations');
    }

    #[Route('/user/{id}/delete', name: 'app_admin_user_delete', methods: ['POST'])]
    public function deleteUser(User $user, Request $request, EntityManagerInterface $entityManager): HttpResponse
    {
        if (!$this->isCsrfTokenValid('delete-user-' . $user->getId(), $request->request->get('_token'))) {
            $this->addFlash('error', 'Token CSRF invalide.');
            return $this->redirectToRoute('app_admin_users');
        }

=======
    #[Route('/user/{id}/ban', name: 'app_admin_user_ban', methods: ['POST'])]
    public function banUser(Utilisateur $user, Request $request, EntityManagerInterface $entityManager): Response
=======
<<<<<<< HEAD
    #[Route('/reclamation/{id}/respond', name: 'app_admin_reclamation_respond', methods: ['POST'])]
    public function respondToReclamation(Request $request, Reclamation $reclamation, EntityManagerInterface $entityManager): HttpResponse
>>>>>>> c139a4e (Résolution des conflits)
    {
        if (!$this->isCsrfTokenValid('ban-user-' . $user->getId(), $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Invalid CSRF token.');
        }

        if ($user->getRole() === 'ROLE_ADMIN') {
            $this->addFlash('error', 'Vous ne pouvez pas bannir un administrateur.');
            return $this->redirectToRoute('app_admin_users');
        }

<<<<<<< HEAD
=======
>>>>>>> Salles
        if ($user === $this->getUser()) {
            $this->addFlash('error', 'Vous ne pouvez pas supprimer votre propre compte.');
=======
    #[Route('/user/{id}/ban', name: 'app_admin_user_ban', methods: ['POST'])]
    public function banUser(Utilisateur $user, Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$this->isCsrfTokenValid('ban-user-' . $user->getId(), $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Invalid CSRF token.');
        }

        if ($user->getRole() === 'ROLE_ADMIN') {
            $this->addFlash('error', 'Vous ne pouvez pas bannir un administrateur.');
            return $this->redirectToRoute('app_admin_users');
        }

<<<<<<< HEAD
=======
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles
        $user->setStatutCompte('banned');
        $entityManager->flush();

        $this->addFlash('success', 'L\'utilisateur a été banni avec succès.');
        return $this->redirectToRoute('app_admin_users');
    }

    #[Route('/user/{id}/unban', name: 'app_admin_user_unban', methods: ['POST'])]
    public function unbanUser(Utilisateur $user, Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$this->isCsrfTokenValid('unban-user-' . $user->getId(), $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Invalid CSRF token.');
        }

        $user->setStatutCompte('active');
        $entityManager->flush();

        $this->addFlash('success', 'L\'utilisateur a été débanni avec succès.');
        return $this->redirectToRoute('app_admin_users');
    }

    #[Route('/user/{id}/delete', name: 'app_admin_user_delete', methods: ['POST'])]
    public function deleteUser(Utilisateur $user, Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$this->isCsrfTokenValid('delete-user-' . $user->getId(), $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Invalid CSRF token.');
        }

        if ($user->getRole() === 'ROLE_ADMIN') {
            $this->addFlash('error', 'Vous ne pouvez pas supprimer un administrateur.');
<<<<<<< HEAD
>>>>>>> 6ab9b1d (Initial commit)
=======
<<<<<<< HEAD
=======
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles
            return $this->redirectToRoute('app_admin_users');
        }

        $entityManager->remove($user);
        $entityManager->flush();

<<<<<<< HEAD
<<<<<<< HEAD
=======
        $this->addFlash('success', 'L\'utilisateur a été supprimé avec succès.');
=======
<<<<<<< HEAD
>>>>>>> Salles
        $this->addFlash('success', 'Utilisateur supprimé avec succès.');
=======
        $this->addFlash('success', 'L\'utilisateur a été supprimé avec succès.');
>>>>>>> 6ab9b1d (Initial commit)
<<<<<<< HEAD
=======
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles
        return $this->redirectToRoute('app_admin_users');
    }

    #[Route('/user/{id}/toggle-ban', name: 'app_admin_user_toggle_ban', methods: ['POST'])]
<<<<<<< HEAD
<<<<<<< HEAD
=======
    public function toggleUserBan(Utilisateur $user, Request $request, EntityManagerInterface $entityManager): Response
=======
<<<<<<< HEAD
>>>>>>> Salles
    public function toggleUserBan(User $user, Request $request, EntityManagerInterface $entityManager): HttpResponse
=======
    public function toggleUserBan(Utilisateur $user, Request $request, EntityManagerInterface $entityManager): Response
>>>>>>> 6ab9b1d (Initial commit)
<<<<<<< HEAD
=======
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles
    {
        if (!$this->isCsrfTokenValid('toggle-ban-user-' . $user->getId(), $request->request->get('_token'))) {
            $this->addFlash('error', 'Token CSRF invalide.');
            return $this->redirectToRoute('app_admin_users');
        }

        if ($user === $this->getUser()) {
            $this->addFlash('error', 'Vous ne pouvez pas bannir votre propre compte.');
            return $this->redirectToRoute('app_admin_users');
        }

<<<<<<< HEAD
<<<<<<< HEAD
=======
        $newStatus = $user->getStatutCompte() === 'banned' ? 'active' : 'banned';
        $user->setStatutCompte($newStatus);
=======
<<<<<<< HEAD
>>>>>>> Salles
        // Toggle the user's status
        $newStatus = $user->getStatutCompte() === 'banned' ? 'active' : 'banned';
        $user->setStatutCompte($newStatus);
        
=======
        $newStatus = $user->getStatutCompte() === 'banned' ? 'active' : 'banned';
        $user->setStatutCompte($newStatus);
>>>>>>> 6ab9b1d (Initial commit)
<<<<<<< HEAD
=======
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles
        $entityManager->flush();

        $message = $newStatus === 'banned' ? 'Utilisateur banni avec succès.' : 'Utilisateur réactivé avec succès.';
        $this->addFlash('success', $message);
        
        return $this->redirectToRoute('app_admin_users');
    }
<<<<<<< HEAD
<<<<<<< HEAD
=======

    #[Route('/reclamation/{id}/respond', name: 'app_admin_reclamation_respond', methods: ['POST'])]
    public function respondToReclamation(Reclamation $reclamation, Request $request, EntityManagerInterface $entityManager): Response
    {
        $responseContent = $request->request->get('response');
        if (!$responseContent) {
            $this->addFlash('error', 'La réponse ne peut pas être vide.');
            return $this->redirectToRoute('app_admin_reclamations');
        }

        $response = new ReclamationResponse();
        $response->setContenu($responseContent);
        $response->setReclamation($reclamation);

        $reclamation->setStatut('resolved');
        $reclamation->setResponse($response);

        $entityManager->persist($response);
        $entityManager->flush();

        $this->addFlash('success', 'Votre réponse a été envoyée avec succès.');
        return $this->redirectToRoute('app_admin_reclamations');
    }
//Salles//

#[Route('/new', name: 'app_admin_salle_new', methods: ['GET', 'POST'])]
public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
{
    $salle = new Salle();
    $form = $this->createForm(SalleType::class, $salle);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $imageFiles = $form->get('imageFile')->getData();
        
        $uploadedImages = [];
        foreach ($imageFiles as $imageFile) {
            $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

            try {
                $imageFile->move(
                    $this->getParameter('salles_directory'),
                    $newFilename
                );
                $uploadedImages[] = $newFilename;
            } catch (FileException $e) {
                $this->addFlash('error', 'Erreur lors de l\'upload d\'une image');
            }
        }

        if (!empty($uploadedImages)) {
            $salle->setImageSalle(implode(',', $uploadedImages));
        }

        $entityManager->persist($salle);
        $entityManager->flush();

        $this->addFlash('success', 'La salle a été créée avec succès');
        return $this->redirectToRoute('app_admin_salles_full');
    }

    return $this->render('admin/salle/new.html.twig', [
        'salle' => $salle,
        'form' => $form->createView(),
    ]);
}
=======
<<<<<<< HEAD
>>>>>>> Salles
}
=======

    #[Route('/reclamation/{id}/respond', name: 'app_admin_reclamation_respond', methods: ['POST'])]
    public function respondToReclamation(Reclamation $reclamation, Request $request, EntityManagerInterface $entityManager): Response
    {
        $responseContent = $request->request->get('response');
        if (!$responseContent) {
            $this->addFlash('error', 'La réponse ne peut pas être vide.');
            return $this->redirectToRoute('app_admin_reclamations');
        }

        $response = new ReclamationResponse();
        $response->setContenu($responseContent);
        $response->setReclamation($reclamation);

        $reclamation->setStatut('resolved');
        $reclamation->setResponse($response);

        $entityManager->persist($response);
        $entityManager->flush();

        $this->addFlash('success', 'Votre réponse a été envoyée avec succès.');
        return $this->redirectToRoute('app_admin_reclamations');
    }
//Salles//

#[Route('/new', name: 'app_admin_salle_new', methods: ['GET', 'POST'])]
public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
{
    $salle = new Salle();
    $form = $this->createForm(SalleType::class, $salle);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $imageFiles = $form->get('imageFile')->getData();
        
        $uploadedImages = [];
        foreach ($imageFiles as $imageFile) {
            $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

            try {
                $imageFile->move(
                    $this->getParameter('salles_directory'),
                    $newFilename
                );
                $uploadedImages[] = $newFilename;
            } catch (FileException $e) {
                $this->addFlash('error', 'Erreur lors de l\'upload d\'une image');
            }
        }

        if (!empty($uploadedImages)) {
            $salle->setImageSalle(implode(',', $uploadedImages));
        }

        $entityManager->persist($salle);
        $entityManager->flush();

        $this->addFlash('success', 'La salle a été créée avec succès');
        return $this->redirectToRoute('app_admin_salles_full');
    }

    return $this->render('admin/salle/new.html.twig', [
        'salle' => $salle,
        'form' => $form->createView(),
    ]);
}
<<<<<<< HEAD
=======
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles


#[Route('/admin/salle/{id}/edit', name: 'app_admin_salle_edit', methods: ['GET', 'POST'])]
public function edit(
    Request $request,
    Salle $salle,
    EntityManagerInterface $entityManager,
    SluggerInterface $slugger
): Response {
    $form = $this->createForm(SalleType::class, $salle);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $imageFile = $form->get('imageFile')->getData();

        if ($imageFile) {
            $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

            try {
                $imageFile->move(
                    $this->getParameter('salles_directory'),
                    $newFilename
                );

                // Supprimer l'ancienne image si elle existe
                if ($salle->getImageSalle()) {
                    $oldImagePath = $this->getParameter('salles_directory') . '/' . $salle->getImageSalle();
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                $salle->setImageSalle($newFilename);
            } catch (FileException $e) {
                $this->addFlash('error', 'Une erreur est survenue lors de l\'upload de l\'image.');
            }
        }

        $entityManager->flush();
        $this->addFlash('success', 'La salle a été modifiée avec succès !');

        return $this->redirectToRoute('app_admin_salles_full');
    }

    return $this->render('admin/salle/edit.html.twig', [
        'form' => $form->createView(),
        'salle' => $salle
    ]);
}

  



#[Route('/{idSalle}', name: 'admin_salle_delete', methods: ['POST'])]
public function delete(Request $request, Salle $salle, EntityManagerInterface $entityManager): Response
{
    if ($this->isCsrfTokenValid('delete'.$salle->getIdSalle(), $request->request->get('_token'))) {
        $entityManager->remove($salle);
        $entityManager->flush();
    }

    return $this->redirectToRoute('app_admin_salles_full', [], Response::HTTP_SEE_OTHER);
}



    

    #[Route('/salle/{idSalle}/details', name: 'admin_salle_details')]
    public function adminDetailsSalle(Salle $salle, EntityManagerInterface $entityManager): Response
    {
        $reservations = $entityManager->getRepository(Reservation::class)
            ->createQueryBuilder('r')
            ->leftJoin('r.user', 'u')
            ->where('r.salle = :salle')
            ->setParameter('salle', $salle)
            ->orderBy('r.dateDebut', 'ASC')
            ->getQuery()
            ->getResult();

        $events = [];
        foreach ($reservations as $reservation) {
            $events[] = [
                'title' => 'Réservé par ' . $reservation->getUser()->getNom() . ' ' . $reservation->getUser()->getPrenom(),
                'start' => $reservation->getDateDebut()->format('Y-m-d\TH:i:s'),
                'end' => $reservation->getDateFin()->format('Y-m-d\TH:i:s'),
                'color' => '#ff0000',
                'extendedProps' => [
                    'reservationId' => $reservation->getIdReservation(),
                    'userEmail' => $reservation->getUser()->getEmail(),
                ]
            ];
        }

        $stats = [
            'totalReservations' => count($reservations),
            'reservationsThisMonth' => count(array_filter($reservations, function($r) {
                return $r->getDateDebut() >= new \DateTime('first day of this month');
            })),
            'upcomingReservations' => count(array_filter($reservations, function($r) {
                return $r->getDateDebut() >= new \DateTime();
            }))
        ];

        return $this->render('admin/salle/details.html.twig', [
            'salle' => $salle,
            'events' => json_encode($events),
            'reservations' => $reservations,
            'stats' => $stats,
            'currentDate' => new \DateTime()
        ]);
    }




////////////************/// */////



    #[Route('/offres', name: 'app_admin_offres')]
public function listOffres(OffreRepository $offreRepository): Response
{
    $offres = $offreRepository->findAll();

    return $this->render('admin/offre/index.html.twig', [
        'offres' => $offres,
    ]);
}



#[Route('/demandes', name: 'app_admin_demandes')]
public function listDemandes(DemandeRepository $demandeRepository): Response
{
    $demandes = $demandeRepository->findAll();

    return $this->render('admin/demande/index.html.twig', [
        'demandes' => $demandes,
    ]);
}

#[Route('/commandes-decorations', name: 'app_admin_commandes')]
public function listCommandes(CommandeDecorationRepository $commandeRepo): Response
{
    $commandes = $commandeRepo->findBy([], ['dateCommande' => 'DESC']);

    return $this->render('admin/commande/index.html.twig', [
        'commandes' => $commandes,
    ]);
}

#[Route('/comandes-decorations', name: 'app_admin_decorations')]
public function listDecorations(DecorationRepository $decorationRepository): Response
{
    $decorations = $decorationRepository->findAll();

    return $this->render('admin/decoration/index.html.twig', [
        'decorations' => $decorations,
    ]);
}
#[Route('/admin/decoration/{id}/delete', name: 'admin_decoration_delete', methods: ['POST'])]
public function deleteDecoration(Request $request, Decoration $decoration, EntityManagerInterface $em): Response
{
    if ($this->isCsrfTokenValid('delete_decoration_' . $decoration->getIdDecor(), $request->request->get('_token'))) {
        $em->remove($decoration);
        $em->flush();

        $this->addFlash('success', 'Décoration supprimée avec succès.');
    }

    return $this->redirectToRoute('app_admin_decorations');
}

<<<<<<< HEAD
}
>>>>>>> 6ab9b1d (Initial commit)
=======
<<<<<<< HEAD
}
=======
}
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles
