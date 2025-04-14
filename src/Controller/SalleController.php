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
        $salle = new Salle();
        $user = $this->getUser();
        
        if (!$user) {
            $this->addFlash('error', 'Vous devez être connecté pour ajouter une salle.');
            return $this->redirectToRoute('app_login');
        }
        
        $salle->setUser($user);
        $form = $this->createForm(SalleType::class, $salle);
        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            if (!$form->isValid()) {
                // Les erreurs seront automatiquement passées au template
            }
            
            if ($form->isValid()) {
                // ... traitement du formulaire valide ...
                $this->addFlash('success', 'La salle a été créée avec succès!');
                return $this->redirectToRoute('app_profilsalle');
            }
        }
        
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
    #[Route('/salle/profil/{id}', name: 'app_salle_profil')]
    public function profil(SalleRepository $salleRepository, Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $salle = $salleRepository->find($id);
        if (!$salle) {
            throw $this->createNotFoundException('Salle non trouvée');
        }
    
        // Créez le formulaire d'édition
        $editForm = $this->createForm(SalleType::class, $salle);
        $editForm->handleRequest($request);
    
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            // Gestion de l'upload de fichier
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
        $form = $this->createForm(SalleType::class, $salle);
        $form->handleRequest($request);
    
        if ($form->isSubmitted()) {
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
            
        }
    
        return $this->render('salle/edit_salle_modal.html.twig', [
            'form' => $form->createView(),
            'salle' => $salle
        ]);
    }

    #[Route('/{idSalle}', name: 'app_salle_delete', methods: ['POST'])]
    public function delete(Request $request, Salle $salle): Response
    {
        if ($this->isCsrfTokenValid('delete'.$salle->getIdSalle(), $request->request->get('_token'))) {
            $this->entityManager->remove($salle);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('app_profilsalle', [], Response::HTTP_SEE_OTHER);
    }
 
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
    
