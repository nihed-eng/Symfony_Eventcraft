<?php

<<<<<<< HEAD

=======
>>>>>>> 6ab9b1d (Initial commit)
namespace App\Controller;

use App\Entity\Decoration;
use App\Form\DecorationType;
<<<<<<< HEAD
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
=======
use App\Repository\DecorationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Psr\Log\LoggerInterface;
>>>>>>> 6ab9b1d (Initial commit)
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
<<<<<<< HEAD
use App\Repository\DecorationRepository;

use Symfony\Component\String\Slugger\SluggerInterface;
=======
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
>>>>>>> 6ab9b1d (Initial commit)

class DecorationController extends AbstractController
{
    #[Route('/decoration', name: 'decoration_index')]
    public function index(Request $request, EntityManagerInterface $entityManager, PaginatorInterface $paginator): Response
    {
        $query = $entityManager->getRepository(Decoration::class)->findAllQuery();

        $decorations = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('decoration/index.html.twig', [
            'pagination' => $decorations,
        ]);
    }

    #[Route('/decoration/create', name: 'decoration_create')]
<<<<<<< HEAD
    public function create(Request $request, EntityManagerInterface $entityManager, Security $security, SluggerInterface $slugger): Response
    {
        $decoration = new Decoration();

        $user = $security->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour ajouter une décoration.');
        }

        $decoration->setUser($user);

        $form = $this->createForm(DecorationType::class, $decoration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('imagedeco')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('error', 'Erreur lors du téléchargement de l\'image.');
                    return $this->redirectToRoute('decoration_create');
                }

                $decoration->setImagedeco($newFilename);
            }

            $entityManager->persist($decoration);
            $entityManager->flush();

            $this->addFlash('success', 'Décoration ajoutée avec succès !');
            return $this->redirectToRoute('decoration_index');
        }

=======
    public function create(
        Request $request,
        EntityManagerInterface $entityManager,
        Security $security,
        SluggerInterface $slugger,
        LoggerInterface $logger
    ): Response {
        $decoration = new Decoration();
        $user = $security->getUser();
        
        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour ajouter une décoration.');
        }
    
        $decoration->setUser($user);
        $form = $this->createForm(DecorationType::class, $decoration);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('imagedeco')->getData();
            
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
    
                try {
                    $targetDirectory = $this->getParameter('images_directory');
                    
                    // Vérification du répertoire
                    if (!file_exists($targetDirectory)) {
                        mkdir($targetDirectory, 0777, true);
                    }
                    
                    $imageFile->move($targetDirectory, $newFilename);
                    
                    // Vérification que le fichier a bien été déplacé
                    if (!file_exists($targetDirectory.'/'.$newFilename)) {
                        throw new \Exception("Échec de l'enregistrement du fichier");
                    }
                    
                    $decoration->setImagedeco($newFilename);
                } catch (\Exception $e) {
                    $logger->error('Erreur upload image: '.$e->getMessage());
                    $this->addFlash('error', 'Erreur lors du téléchargement de l\'image');
                }
            }
    
            $entityManager->persist($decoration);
            $entityManager->flush();
    
            $this->addFlash('success', 'Décoration ajoutée avec succès !');
            return $this->redirectToRoute('decoration_index');
        }
    
>>>>>>> 6ab9b1d (Initial commit)
        return $this->render('decoration/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
<<<<<<< HEAD

=======
>>>>>>> 6ab9b1d (Initial commit)
    #[Route('/decoration/{id}', name: 'decoration_show_one', requirements: ['id' => '\d+'])]
    public function show(DecorationRepository $repo, int $id): Response
    {
        $decoration = $repo->find($id);
    
        if (!$decoration) {
            throw $this->createNotFoundException('Décoration non trouvée.');
        }
    
        return $this->render('decoration/detailsdeco.html.twig', [
            'decoration' => $decoration,
        ]);
    }
    

    #[Route('/decoration/{id}/edit', name: 'decoration_edit')]
    public function edit(Decoration $decoration, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DecorationType::class, $decoration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('decoration_index');
        }

        return $this->render('decoration/edit.html.twig', [
            'form' => $form->createView(),
            'decoration' => $decoration,
        ]);
    }

    #[Route('/decoration/{id}/delete', name: 'decoration_delete', methods: ['POST'])]
    public function delete(Decoration $decoration, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($decoration);
        $entityManager->flush();

        return $this->redirectToRoute('decoration_index');
    }


    #[Route('/home', name: 'decoration_welcom')]
    public function welcome(Request $request, EntityManagerInterface $entityManager, PaginatorInterface $paginator): Response
    {
        $query = $entityManager->getRepository(Decoration::class)->findAllQuery();

        $decorations = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('decoration/welcomdeco.html.twig', [
            'pagination' => $decorations,
        ]);
    }  
    
    




}
