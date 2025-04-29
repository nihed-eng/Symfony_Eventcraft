<?php

namespace App\Controller;

use App\Entity\CommandeDecoration;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Ratchet\Client\connect;

#[Route('/paiement')]
class PaiementController extends AbstractController
{
    #[Route('/create-checkout-session/{id}', name: 'paiement_checkout')]
    public function createCheckoutSession(CommandeDecoration $commande): Response
    {
        \Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

        $montantEnCentimes = intval($commande->getPrix() * 100);

        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => 'Paiement décoration - Commande #' . $commande->getIdCommande(),
                    ],
                    'unit_amount' => $montantEnCentimes,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
          'success_url' => $this->generateUrl('paiement_success', [], UrlGeneratorInterface::ABSOLUTE_URL),
'cancel_url' => $this->generateUrl('paiement_cancel', [], UrlGeneratorInterface::ABSOLUTE_URL),



        ]);

        return $this->redirect($session->url);
    }

    #[Route('/success', name: 'paiement_success')]
    public function success(): Response
    {
        $this->addFlash('success', 'Paiement réussi !');
return $this->redirectToRoute('paimentsucess_index');

    }
    

    private function sendRealTimeNotification(string $message)
    {
        \Ratchet\Client\connect('ws://localhost:8081')->then(function($conn) use ($message) {
            $conn->send($message);
            $conn->close(); 
        }, function ($e) {
            echo "Could not connect: {$e->getMessage()}\n";
        });
    }

    #[Route('/cancel', name: 'paiement_cancel')]
    public function cancel(): Response
    {
        return new Response('❌ Paiement annulé.');
    }
}
