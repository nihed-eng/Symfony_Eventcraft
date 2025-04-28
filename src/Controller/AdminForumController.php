<?php
namespace App\Controller;

use App\Repository\ForumRepository;
use App\Entity\Forum;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/forum')]
class AdminForumController extends AbstractController
{
    #[Route('/', name: 'admin_forum_index')]
    public function index(ForumRepository $forumRepository, Request $request): Response
    {
        $search = $request->query->get('q');
        $forums = $search 
            ? $forumRepository->createQueryBuilder('f')
                ->where('f.titreForum LIKE :search')
                ->setParameter('search', '%' . $search . '%')
                ->getQuery()
                ->getResult()
            : $forumRepository->findAll();

        return $this->render('admin_forum/index.html.twig', [
            'forums' => $forums,
        ]);
    }

    #[Route('/{id}', name: 'admin_forum_delete', methods: ['POST'])]
    public function delete(Request $request, Forum $forum, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete' . $forum->getId(), $request->request->get('_token'))) {
            $em->remove($forum);
            $em->flush();
            $this->addFlash('success', 'Forum supprimé.');
        }

        return $this->redirectToRoute('admin_forum_index');
    }
}
