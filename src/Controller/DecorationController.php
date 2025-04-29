<?php


namespace App\Controller;

use App\Entity\Decoration;
use App\Form\DecorationType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use App\Repository\DecorationRepository;

use Symfony\Component\String\Slugger\SluggerInterface;

class DecorationController extends AbstractController
{
    #[Route('/decoration', name: 'decoration_index')]
    public function index(Request $request, DecorationRepository $decorationRepository, PaginatorInterface $paginator): Response
    {
        $search = $request->query->get('search', '');
        $sort = $request->query->get('sort', '');
        $page = $request->query->getInt('page', 1);
    
        $qb = $decorationRepository->createQueryBuilder('d');
    
        // Recherche par nom
        if (!empty($search)) {
            $qb->andWhere('d.nomDecor LIKE :search')
               ->setParameter('search', '%' . $search . '%');
        }
    
        // Tri dynamique
        switch ($sort) {
            case 'price_asc':
                $qb->orderBy('d.prix', 'ASC');
                break;
            case 'price_desc':
                $qb->orderBy('d.prix', 'DESC');
                break;
            case 'stock_asc':
                $qb->orderBy('d.stock', 'ASC');
                break;
            case 'stock_desc':
                $qb->orderBy('d.stock', 'DESC');
                break;
        }
    
        // Pagination
        $pagination = $paginator->paginate(
            $qb->getQuery(),
            $request->query->getInt('page', 1),
            10,
            [
                'sortFieldParameterName' => null,
                'sortDirectionParameterName' => null,
            ]
        );
    }
    
    #[Route('/decoration/create', name: 'decoration_create')]
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

        return $this->render('decoration/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

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
    
    


    #[Route('/decoration/search', name: 'decoration_search', methods: ['GET'])]
    public function search(Request $request, DecorationRepository $repository): Response
    {
        $term = $request->query->get('term');
    
        $decorations = $repository->createQueryBuilder('d')
            ->where('d.nomDecor LIKE :term')
            ->setParameter('term', '%' . $term . '%')
            ->getQuery()
            ->getResult();
    
        $data = [];
    
        foreach ($decorations as $deco) {
            $data[] = [
                'id' => $deco->getIdDecor(),
                'nom' => $deco->getNomDecor(),
                'prix' => $deco->getPrix(),
                'image' => $deco->getImagedeco()
            ];
        }
    
        return $this->json($data);
    }
    

}
