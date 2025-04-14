<?php

namespace App\Service;

use League\OAuth2\Client\Provider\Google;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;

class GoogleAuthService
{
    private $provider;
    private $userRepository;
    private $entityManager;
    private $session;

    public function __construct(
        UserRepository $userRepository,
        EntityManagerInterface $entityManager,
        RequestStack $requestStack
    ) {
        $clientConfigPath = 'C:\Users\Baha Ayadi\Desktop\client_secret.json';
        
        if (!file_exists($clientConfigPath)) {
            throw new \RuntimeException('Google OAuth configuration file not found. Please create client_secret.json');
        }
        
        $jsonContent = file_get_contents($clientConfigPath);
        if ($jsonContent === false) {
            throw new \RuntimeException('Unable to read Google OAuth configuration file');
        }
        
        $decodedJson = json_decode($jsonContent, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException('Invalid JSON in Google OAuth configuration file');
        }
        
        // Get configuration from web key if it exists, otherwise use root
        $clientConfig = isset($decodedJson['web']) ? $decodedJson['web'] : $decodedJson;
        
        if (!isset($clientConfig['client_id']) || !isset($clientConfig['client_secret'])) {
            throw new \RuntimeException('Missing client_id or client_secret in configuration file');
        }
        
        $this->provider = new Google([
            'clientId'     => $clientConfig['client_id'],
            'clientSecret' => $clientConfig['client_secret'],
            'redirectUri'  => 'http://127.0.0.1:8000/connect/google/check',
        ]);
        
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->session = $requestStack->getSession();
    }

    public function getAuthorizationUrl(): string
    {
        $options = [
            'scope' => [
                'https://www.googleapis.com/auth/userinfo.email',
                'https://www.googleapis.com/auth/userinfo.profile',
            ]
        ];

        $authUrl = $this->provider->getAuthorizationUrl($options);
        $this->session->set('oauth2state', $this->provider->getState());

        return $authUrl;
    }

    public function handleCallback(string $state, string $code): ?User
    {
        try {
            // Verify state
            $savedState = $this->session->get('oauth2state');
            if (!$savedState || $state !== $savedState) {
                $this->session->remove('oauth2state');
                throw new \RuntimeException('Invalid state');
            }

            // Get access token
            $token = $this->provider->getAccessToken('authorization_code', [
                'code' => $code
            ]);

            // Get user details
            $googleUser = $this->provider->getResourceOwner($token);
            
            // Check if user exists
            $user = $this->userRepository->findOneBy(['email' => $googleUser->getEmail()]);
            
            if (!$user) {
                // Create new user
                $user = new User();
                $user->setEmail($googleUser->getEmail());
                $user->setFirstName($googleUser->getFirstName());
                $user->setLastName($googleUser->getLastName());
                $user->setPassword(''); // No password for Google auth
                $user->setRoles(['ROLE_USER']);
                
                // Set default notification settings
                $user->setEmailNotifications([
                    'events' => true,
                    'offers' => true,
                    'forum' => false
                ]);
                
                $user->setPushNotifications([
                    'events' => true,
                    'messages' => false
                ]);
                
                $user->setCreatedAt(new \DateTimeImmutable());
                
                // Profile picture will remain null by default
                
                $this->entityManager->persist($user);
                $this->entityManager->flush();
            }

            return $user;
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to handle Google callback: ' . $e->getMessage());
        }
    }
} 