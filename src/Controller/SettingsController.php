<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Doctrine\ORM\EntityManagerInterface;

#[IsGranted('ROLE_USER')]
class SettingsController extends AbstractController
{
    #[Route('/settings', name: 'app_settings')]
    public function index(): Response
    {
        return $this->render('settings/index.html.twig', [
            'user' => $this->getUser(),
        ]);
    }

    #[Route('/settings/save', name: 'app_settings_save', methods: ['POST'])]
    public function save(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        
        // Update email notifications
        $emailNotifications = $request->request->get('emailNotifications', []);
        $user->setEmailNotifications([
            'events' => isset($emailNotifications['events']),
            'offers' => isset($emailNotifications['offers']),
            'forum' => isset($emailNotifications['forum'])
        ]);

        // Update push notifications
        $pushNotifications = $request->request->get('pushNotifications', []);
        $user->setPushNotifications([
            'events' => isset($pushNotifications['events']),
            'messages' => isset($pushNotifications['messages'])
        ]);

        $entityManager->flush();

        $this->addFlash('success', 'Your settings have been updated successfully.');
        return $this->redirectToRoute('app_settings');
    }
}
