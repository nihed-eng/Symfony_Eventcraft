<?php

namespace App\Controller;

use App\Entity\Forum;
use App\Form\ForumType;
use App\Repository\ForumRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/forum')]
final class ForumController extends AbstractController
{

    #[Route('/', name: 'app_forum_index', methods: ['GET'])]
public function index(Request $request, ForumRepository $forumRepository): Response
{
    $search = $request->query->get('q');

    if ($search) {
        $forums = $forumRepository->createQueryBuilder('f')
            ->where('f.titre_forum LIKE :search')
            ->setParameter('search', '%' . $search . '%')
            ->getQuery()
            ->getResult();
    } else {
        $forums = $forumRepository->findAll();
    }

    return $this->render('forum/index.html.twig', [
        'forums' => $forums,
    ]);
}
#[Route('/new', name: 'app_forum_new', methods: ['GET', 'POST'])]
public function new(Request $request, EntityManagerInterface $entityManager): Response
{
    $forum = new Forum();
    $form = $this->createForm(ForumType::class, $forum);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // 🕒 définir automatiquement la date actuelle
        $forum->setDateCreation(new \DateTime());

        $entityManager->persist($forum);
        $entityManager->flush();

        return $this->redirectToRoute('app_forum_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->render('forum/new.html.twig', [
        'forum' => $forum,
        'form' => $form,
    ]);
}

    

    #[Route('/{id}', name: 'app_forum_show', methods: ['GET'])]
    public function show(Forum $forum): Response
    {
        return $this->render('forum/show.html.twig', [
            'forum' => $forum,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_forum_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Forum $forum, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ForumType::class, $forum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_forum_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('forum/edit.html.twig', [
            'forum' => $forum,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_forum_delete', methods: ['POST'])]
    public function delete(Request $request, Forum $forum, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$forum->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($forum);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_forum_index', [], Response::HTTP_SEE_OTHER);
    }
}
