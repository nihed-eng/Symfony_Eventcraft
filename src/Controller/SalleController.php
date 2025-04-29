<?php

// src/Controller/SalleController.php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Entity\Salle;
use App\Entity\Reservation;

use GuzzleHttp\Client;

use App\Form\SalleType;
use App\Form\ReservationType;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
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

    #[Route('/new', name: 'app_salle_new', methods: ['GET', 'POST'])]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Créer l'objet salle
        $salle = new Salle();
        
        // Récupérer l'utilisateur connecté
        $user = $this->getUser(); // Récupère l'utilisateur connecté
        
        // Vérifier si l'utilisateur est connecté
        if (!$user) {
            $this->addFlash('error', 'Vous devez être connecté pour ajouter une salle.');
            return $this->redirectToRoute('app_login'); 
        }
        
        // Associer l'utilisateur connecté à la salle
        $salle->setUser($user);
        
        // Créer et gérer le formulaire
        $form = $this->createForm(SalleType::class, $salle);
        $form->handleRequest($request);
        
<<<<<<< Updated upstream
        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Gérer le fichier image
            $imageFile = $form->get('imageFile')->getData();
            
            if ($imageFile) {
                $newFilename = uniqid().'.'.$imageFile->guessExtension();
                $imageFile->move(
                    $this->getParameter('images_directory'), // Assure-toi d'avoir configuré le paramètre 'images_directory'
                    $newFilename
                );
                $salle->setImageSalle($newFilename);  // Associer le nom du fichier image à la salle
            }
        
            // Persister et sauvegarder la salle
            $entityManager->persist($salle);
            $entityManager->flush();
        
            // Redirection vers la liste des salles
            return $this->redirectToRoute('app_profilsalle');
=======
        if ($form->isSubmitted()) {
            if (!$form->isValid()) {
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
            }
>>>>>>> Stashed changes
        }
        
        // Afficher le formulaire
        return $this->render('salle/addsalle.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/salle/{idSalle}', name: 'app_salle_show')]
    public function show(Salle $salle): Response
    {
        return $this->render('salle/show.html.twig', [
            'salle' => $salle,
        ]);
    }
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
        
        if (!$salle) {
            throw $this->createNotFoundException('Salle non trouvée');
        }
    
        $editForm = $this->createForm(SalleType::class, $salle);
        $editForm->handleRequest($request);
    
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            // Gestion de l'upload
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
            return $this->redirectToRoute('app_salle_profil', ['idSalle' => $idSalle]);
        }
    
        return $this->render('profilesalle/profilsalle.html.twig', [
            'salles' => $salles, // Toutes les salles
            'current_salle' => $salle, // Salle en cours d'édition
            'edit_form' => $editForm->createView(),
        ]);
    }

<<<<<<< Updated upstream
  // SalleController.php


#[Route('/edit/{idSalle}', name: 'app_salle_edit', methods: ['GET', 'POST'])]
public function edit(Request $request, Salle $salle): Response
{
    $form = $this->createForm(SalleType::class, $salle);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $imageFile = $form->get('imageFile')->getData();
        
        if ($imageFile) {
            $newFilename = uniqid().'.'.$imageFile->guessExtension();
            $imageFile->move(
                $this->getParameter('images_directory'),
                $newFilename
            );
            $salle->setImageSalle($newFilename);
        }

        $this->entityManager->flush();
        return $this->redirectToRoute('app_profilsalle');
=======
    #[Route('/edit/{idSalle}', name: 'app_salle_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request, 
        Salle $salle, 
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger
    ): Response {
        $user = $this->getUser();
        if (!$user || $user !== $salle->getUser()) {
            $this->addFlash('error', 'Vous n\'avez pas les permissions nécessaires pour modifier cette salle.');
            return $this->redirectToRoute('app_profilsalle');
        }
    
        $form = $this->createForm(SalleType::class, $salle);
        $form->handleRequest($request);
    
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                // Gestion des images
                $imageFiles = $form->get('imageFile')->getData();
                
                if ($imageFiles) {
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
                        // Supprimer les anciennes images si nécessaire
                        if ($salle->getImageSalle()) {
                            $oldImages = explode(',', $salle->getImageSalle());
                            foreach ($oldImages as $oldImage) {
                                $oldImagePath = $this->getParameter('salles_directory').'/'.$oldImage;
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
            } else {
                $this->addFlash('error', 'Veuillez corriger les erreurs dans le formulaire.');
            }
        }
    
        return $this->render('admin/salle/edit.html.twig', [
            'form' => $form->createView(),
            'salle' => $salle
        ]);
>>>>>>> Stashed changes
    }

    return $this->render('salle/edit_salle_modal.html.twig', [
        'form' => $form->createView(),
        'salle' => $salle,
    ]);
} 
    


    #[Route('/{idSalle}', name: 'app_salle_delete', methods: ['POST'])]
    public function delete(Request $request, Salle $salle): Response
    {
        if ($this->isCsrfTokenValid('delete'.$salle->getIdSalle(), $request->request->get('_token'))) {
            $this->entityManager->remove($salle);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('app_salle_index', [], Response::HTTP_SEE_OTHER);
    }
 
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


}
    
