<?php

// src/Controller/SalleController.php

namespace App\Controller;

<<<<<<< HEAD
=======


>>>>>>> 6ab9b1d (Initial commit)
use App\Entity\Utilisateur;
use App\Entity\Salle;
use App\Entity\Reservation;

use GuzzleHttp\Client;
<<<<<<< HEAD

use App\Form\SalleType;
use App\Form\ReservationType;

=======
use App\Repository\SalleRepository;
use App\Repository\ReservationRepository;
use App\Form\SalleType;
use App\Form\ReservationType;
>>>>>>> 6ab9b1d (Initial commit)
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
<<<<<<< HEAD
=======
use Symfony\Component\String\Slugger\SluggerInterface;

>>>>>>> 6ab9b1d (Initial commit)
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/salle')]
final class SalleController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route(name: 'app_salle_index', methods: ['GET'])]
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $salles = $this->entityManager->getRepository(Salle::class)->findAll();
    
        // Vérifiez si les données des images sont correctement récupérées
        foreach ($salles as $salle) {
            // Debug: vérifiez que le nom de l'image est correct
            dump($salle->getImageSalle());
        }
    
        $pagination = $paginator->paginate(
            $salles,
            $request->query->getInt('page', 1), // Page number
           4 // Limit per page
        );
    
        return $this->render('salle/sallehome.html.twig', [
            'pagination' => $pagination,
        ]);
    }

<<<<<<< HEAD
   
=======
>>>>>>> 6ab9b1d (Initial commit)
    #[Route('/new', name: 'app_salle_new', methods: ['GET', 'POST'])]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $salle = new Salle();
        $user = $this->getUser();
        
        if (!$user) {
            $this->addFlash('error', 'Vous devez être connecté pour ajouter une salle.');
<<<<<<< HEAD
            return $this->redirectToRoute('app_login');
=======
            return $this->redirectToRoute('app_login'); 
>>>>>>> 6ab9b1d (Initial commit)
        }
        
        $salle->setUser($user);
        $form = $this->createForm(SalleType::class, $salle);
        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            if (!$form->isValid()) {
<<<<<<< HEAD
                // Les erreurs seront automatiquement passées au template
            }
            
            if ($form->isValid()) {
                // ... traitement du formulaire valide ...
                $this->addFlash('success', 'La salle a été créée avec succès!');
                return $this->redirectToRoute('app_profilsalle');
=======
                foreach ($form->getErrors(true) as $error) {
                    $this->addFlash('error', $error->getMessage());
                }
            } else {
                $imageFile = $form->get('imageFile')->getData();
                
                if ($imageFile) {
                    $newFilename = uniqid().'.'.$imageFile->guessExtension();
                    try {
                        $imageFile->move(
                            $this->getParameter('images_directory'),
                            $newFilename
                        );
                        $salle->setImageSalle($newFilename);
                    } catch (FileException $e) {
                        $this->addFlash('error', 'Erreur lors de l\'upload de l\'image');
                    }
                }
            
                try {
                    $entityManager->persist($salle);
                    $entityManager->flush();
                    $this->addFlash('success', 'La salle a été créée avec succès!');
                    return $this->redirectToRoute('app_profilsalle');
                } catch (\Exception $e) {
                    $this->addFlash('error', 'Erreur base de données : '.$e->getMessage());
                }
>>>>>>> 6ab9b1d (Initial commit)
            }
        }
        
        return $this->render('salle/addsalle.html.twig', [
            'form' => $form->createView(),
        ]);
    }
<<<<<<< HEAD
    
    
=======

>>>>>>> 6ab9b1d (Initial commit)

    #[Route('/salle/{idSalle}', name: 'app_salle_show')]
    public function show(Salle $salle): Response
    {
        return $this->render('salle/show.html.twig', [
            'salle' => $salle,
        ]);
    }
<<<<<<< HEAD
    #[Route('/salle/profil/{id}', name: 'app_salle_profil')]
    public function profil(SalleRepository $salleRepository, Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $salle = $salleRepository->find($id);
=======
    #[Route('/salle/profil/{idSalle}', name: 'app_salle_profil')]
    public function profil(
        SalleRepository $salleRepository, 
        Request $request, 
        EntityManagerInterface $entityManager, 
        int $idSalle
    ): Response {
        // Récupère TOUTES les salles de l'utilisateur connecté
        $salles = $salleRepository->findBy(['user' => $this->getUser()]);
        
        // Récupère la salle spécifique pour l'édition
        $salle = $salleRepository->find($idSalle);
        
>>>>>>> 6ab9b1d (Initial commit)
        if (!$salle) {
            throw $this->createNotFoundException('Salle non trouvée');
        }
    
<<<<<<< HEAD
        // Créez le formulaire d'édition
=======
>>>>>>> 6ab9b1d (Initial commit)
        $editForm = $this->createForm(SalleType::class, $salle);
        $editForm->handleRequest($request);
    
        if ($editForm->isSubmitted() && $editForm->isValid()) {
<<<<<<< HEAD
            // Gestion de l'upload de fichier
=======
            // Gestion de l'upload
>>>>>>> 6ab9b1d (Initial commit)
            $imageFile = $editForm->get('imageFile')->getData();
            if ($imageFile) {
                $newFilename = md5(uniqid()).'.'.$imageFile->guessExtension();
                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );
                $salle->setImageSalle($newFilename);
            }
    
            $entityManager->flush();
<<<<<<< HEAD
            return $this->redirectToRoute('app_salle_profil', ['id' => $id]);
        }
    
        return $this->render('profilesalle/profilsalle.html.twig', [
            'salle' => $salle,
            'edit_form' => $editForm->createView(), // Passez le formulaire sous le nom 'edit_form'
        ]);
    }
    

    #[Route('/edit/{idSalle}', name: 'app_salle_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Salle $salle, EntityManagerInterface $entityManager): Response
    {
=======
            return $this->redirectToRoute('app_salle_profil', ['idSalle' => $idSalle]);
        }
    
        return $this->render('profilesalle/profilsalle.html.twig', [
            'salles' => $salles, // Toutes les salles
            'current_salle' => $salle, // Salle en cours d'édition
            'edit_form' => $editForm->createView(),
        ]);
    }

    #[Route('/edit/{idSalle}', name: 'app_salle_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Salle $salle,
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger
    ): Response { {
        $user = $this->getUser();
        if (!$user || $user !== $salle->getUser()) {
            $this->addFlash('error', 'Vous n\'avez pas les permissions nécessaires pour modifier cette salle.');
            return $this->redirectToRoute('app_profilsalle');
        }
    
>>>>>>> 6ab9b1d (Initial commit)
        $form = $this->createForm(SalleType::class, $salle);
        $form->handleRequest($request);
    
        if ($form->isSubmitted()) {
<<<<<<< HEAD
            if ($form->isValid()) {
                $imageFile = $form->get('imageFile')->getData();
                
                if ($imageFile) {
                    // Supprimer l'ancienne image si elle existe
                    if ($salle->getImageSalle()) {
                        $oldImagePath = $this->getParameter('images_directory').'/'.$salle->getImageSalle();
                        if (file_exists($oldImagePath)) {
                            unlink($oldImagePath);
                        }
                    }
                    
                    $newFilename = uniqid().'.'.$imageFile->guessExtension();
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                    $salle->setImageSalle($newFilename);
                }
    
                $entityManager->flush();
                $this->addFlash('success', 'La salle a été modifiée avec succès!');
                return $this->redirectToRoute('app_profilsalle');
            }
            
=======
            if (!$form->isValid()) {
                foreach ($form->getErrors(true) as $error) {
                    $this->addFlash('error', $error->getMessage());
                }
            } else {
                $imageFiles = $form->get('imageFile')->getData();
    
                if ($imageFiles && is_array($imageFiles)) {
                    $uploadedImages = [];
    
                    foreach ($imageFiles as $imageFile) {
                        if ($imageFile) {
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
                                $this->addFlash('error', 'Erreur lors de l\'upload d\'une image : '.$e->getMessage());
                            }
                        }
                    }
    
                    if (!empty($uploadedImages)) {
                        // Supprimer les anciennes images
                        if ($salle->getImageSalle()) {
                            $oldImages = explode(',', $salle->getImageSalle());
                            foreach ($oldImages as $oldImage) {
                                $oldImagePath = $this->getParameter('salles_directory') . '/' . $oldImage;
                                if (file_exists($oldImagePath)) {
                                    unlink($oldImagePath);
                                }
                            }
                        }
    
                        $salle->setImageSalle(implode(',', $uploadedImages));
                    }
                }
    
                try {
                    $entityManager->flush();
                    $this->addFlash('success', 'La salle a été modifiée avec succès !');
                    return $this->redirectToRoute('app_profilsalle');
                } catch (\Exception $e) {
                    $this->addFlash('error', 'Erreur base de données : '.$e->getMessage());
                }
            }
>>>>>>> 6ab9b1d (Initial commit)
        }
    
        return $this->render('salle/edit_salle_modal.html.twig', [
            'form' => $form->createView(),
            'salle' => $salle
        ]);
<<<<<<< HEAD
    }
=======
    } }
    




>>>>>>> 6ab9b1d (Initial commit)

    #[Route('/{idSalle}', name: 'app_salle_delete', methods: ['POST'])]
    public function delete(Request $request, Salle $salle): Response
    {
        if ($this->isCsrfTokenValid('delete'.$salle->getIdSalle(), $request->request->get('_token'))) {
            $this->entityManager->remove($salle);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('app_profilsalle', [], Response::HTTP_SEE_OTHER);
    }
<<<<<<< HEAD
 
    #[Route('/detailsalle/{idSalle}', name: 'details_salle')]
public function detailsSalle(Salle $salle, EntityManagerInterface $entityManager): Response
{
    // Récupérer les réservations de la salle
    $reservations = $entityManager->getRepository(Reservation::class)
        ->findBy(['salle' => $salle]);

    // Formatage des événements pour FullCalendar
    $events = [];
    foreach ($reservations as $reservation) {
        $events[] = [
            'title' => 'Réservation',
            'start' => $reservation->getDateDebut()->format('Y-m-d H:i:s'),
            'end' => $reservation->getDateFin()->format('Y-m-d H:i:s'),
        ];
    }

    // Adresse et coordonnées
    $adresse = $salle->getLocationSalle();
    $coordinates = $this->getCoordinatesFromAddress($adresse);

    return $this->render('salle/detailsalle.html.twig', [
        'salle' => $salle,
        'coordinates' => $coordinates,
        'adresse' => $adresse,
        'events' => json_encode($events),  // Passer les événements pour FullCalendar
        'dateReservation' => $reservations ? $reservations[0]->getDateDebut() : null // Assurer que dateReservation existe
    ]);
}
=======



    
 
    #[Route('/detailsalle/{idSalle}', name: 'details_salle')]
    public function detailsSalle(Salle $salle, EntityManagerInterface $entityManager): Response
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
    
        return $this->render('salle/detailsalle.html.twig', [
            'salle' => $salle,
            'events' => json_encode($events),
            'reservations' => $reservations,
            'stats' => $stats,
            'currentDate' => new \DateTime()
        ]);
    }
    
>>>>>>> 6ab9b1d (Initial commit)

    private function getCoordinatesFromAddress(string $adresse): array
    {
        $client = new Client();
        $apiKey = 'VOTRE_CLE_API_ICI'; // Remplacez par votre vraie clé
        $url = sprintf(
            'https://maps.googleapis.com/maps/api/geocode/json?address=%s&key=%s',
            urlencode($adresse),
            $apiKey
        );

        try {
            $response = $client->get($url);
            $data = json_decode($response->getBody(), true);

            if ($data['status'] === 'OK') {
                return $data['results'][0]['geometry']['location'];
            }
        } catch (\Exception $e) {
            // Log l'erreur
        }

        return ['lat' => 48.8566, 'lng' => 2.3522]; // Valeurs par défaut
    }

    #[Route('/ajax/salles', name: 'ajax_salles', methods: ['GET'])]
    public function ajaxSalles(EntityManagerInterface $entityManager): JsonResponse
    {
        $salles = $entityManager->getRepository(Salle::class)->findAll();
        
        $data = [];
        foreach ($salles as $salle) {
            $data[] = [
                'id' => $salle->getIdSalle(),
                'nom' => $salle->getNomSalle(),
                'image' => $this->getParameter('images_directory') . '/' . $salle->getImageSalle(),
            ];
        }
    
        return new JsonResponse($data);
    }
    
#[Route('/reservations/{idReservation}', name: 'app_reservation_show', methods: ['GET'])]
public function showReservation(Reservation $reservation = null): Response
{
    if (!$reservation) {
        throw $this->createNotFoundException('Reservation not found.');
    }

    return $this->render('reservation/show.html.twig', [
        'reservation' => $reservation,
    ]);
}


<<<<<<< HEAD
=======



#[Route('/salles/search', name: 'app_salle_search', methods: ['GET'])]
public function search(Request $request, SalleRepository $salleRepository, ReservationRepository $reservationRepository, PaginatorInterface $paginator): Response
{
    // Créer la requête de base
    $query = $salleRepository->createQueryBuilder('s');

    // Filtre par localisation
    if ($location = $request->query->get('location')) {
        $query->andWhere('s.locationSalle LIKE :location')
             ->setParameter('location', '%'.$location.'%');
    }

    // Filtre par date de début (vérification des réservations)
    if ($dateStart = $request->query->get('date_start')) {
        $dateStartObj = new \DateTime($dateStart);
        
        // Sous-requête pour trouver les salles non réservées à cette date
        $subQuery = $reservationRepository->createQueryBuilder('r')
            ->select('IDENTITY(r.salle)')
            ->where(':date BETWEEN r.dateDebut AND r.dateFin')
            ->getDQL();

        $query->andWhere($query->expr()->notIn('s.idSalle', $subQuery))
             ->setParameter('date', $dateStartObj);
    }

    // Filtre par capacité
    if ($capacity = $request->query->get('capacity')) {
        $query->andWhere('s.capacite >= :capacity')
             ->setParameter('capacity', $capacity);
    }

    // Filtre par prix maximum
    if ($maxPrice = $request->query->get('max_price')) {
        $query->andWhere('s.prix <= :maxPrice')
             ->setParameter('maxPrice', $maxPrice);
    }

    // Exécuter la requête
    $query = $query->getQuery();
    
    $pagination = $paginator->paginate(
        $query,
        $request->query->getInt('page', 1),
        4
    );

    // Gestion de la réponse AJAX
    if ($request->isXmlHttpRequest()) {
        return $this->render('salle/_search_results.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    return $this->render('salle/sallehome.html.twig', [
        'pagination' => $pagination,
    ]);
}

>>>>>>> 6ab9b1d (Initial commit)
}
    
