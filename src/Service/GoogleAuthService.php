<?php

namespace App\Service;

use League\OAuth2\Client\Provider\Google;
<<<<<<< HEAD
<<<<<<< HEAD
=======
use App\Repository\UtilisateurRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Utilisateur;
use Psr\Log\LoggerInterface;
=======
<<<<<<< HEAD
>>>>>>> Salles
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
=======
use App\Repository\UtilisateurRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Utilisateur;
use Psr\Log\LoggerInterface;
>>>>>>> 6ab9b1d (Initial commit)
<<<<<<< HEAD
=======
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles

class GoogleAuthService
{
    private $provider;
<<<<<<< HEAD
<<<<<<< HEAD
    private $userRepository;
    private $entityManager;
    private $session;

    public function __construct(
        UserRepository $userRepository,
        EntityManagerInterface $entityManager,
        RequestStack $requestStack
    ) {
=======
    private $utilisateurRepository;
=======
<<<<<<< HEAD
    private $userRepository;
>>>>>>> c139a4e (Résolution des conflits)
    private $entityManager;
    private $session;
    private $logger;

    public function __construct(
        UtilisateurRepository $utilisateurRepository,
        EntityManagerInterface $entityManager,
        RequestStack $requestStack,
        LoggerInterface $logger = null
    ) {
<<<<<<< HEAD
        $this->logger = $logger;
=======
>>>>>>> Salles
=======
    private $utilisateurRepository;
    private $entityManager;
    private $session;
    private $logger;

    public function __construct(
        UtilisateurRepository $utilisateurRepository,
        EntityManagerInterface $entityManager,
        RequestStack $requestStack,
        LoggerInterface $logger = null
    ) {
        $this->logger = $logger;
>>>>>>> 6ab9b1d (Initial commit)
<<<<<<< HEAD
=======
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles
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
        
<<<<<<< HEAD
<<<<<<< HEAD
=======
        $this->utilisateurRepository = $utilisateurRepository;
=======
<<<<<<< HEAD
>>>>>>> Salles
        $this->userRepository = $userRepository;
=======
        $this->utilisateurRepository = $utilisateurRepository;
>>>>>>> 6ab9b1d (Initial commit)
<<<<<<< HEAD
=======
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles
        $this->entityManager = $entityManager;
        $this->session = $requestStack->getSession();
    }

<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles
    private function log($message, $level = 'info', $context = [])
    {
        if ($this->logger) {
            $this->logger->$level($message, $context);
        }
    }

<<<<<<< HEAD
>>>>>>> 6ab9b1d (Initial commit)
=======
<<<<<<< HEAD
=======
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles
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

<<<<<<< HEAD
<<<<<<< HEAD
=======
    public function handleCallback(string $state, string $code): ?Utilisateur
=======
<<<<<<< HEAD
>>>>>>> Salles
    public function handleCallback(string $state, string $code): ?User
=======
    public function handleCallback(string $state, string $code): ?Utilisateur
>>>>>>> 6ab9b1d (Initial commit)
<<<<<<< HEAD
=======
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles
    {
        try {
            // Verify state
            $savedState = $this->session->get('oauth2state');
            if (!$savedState || $state !== $savedState) {
                $this->session->remove('oauth2state');
<<<<<<< HEAD
<<<<<<< HEAD
=======
                $this->log('Invalid OAuth state', 'error');
>>>>>>> 6ab9b1d (Initial commit)
=======
                $this->log('Invalid OAuth state', 'error');
=======
<<<<<<< HEAD
=======
                $this->log('Invalid OAuth state', 'error');
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles
                throw new \RuntimeException('Invalid state');
            }

            // Get access token
            $token = $this->provider->getAccessToken('authorization_code', [
                'code' => $code
            ]);

            // Get user details
            $googleUser = $this->provider->getResourceOwner($token);
<<<<<<< HEAD
<<<<<<< HEAD
            
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
=======
            $userData = $googleUser->toArray();
=======
<<<<<<< HEAD
>>>>>>> c139a4e (Résolution des conflits)
            
            // Dump user data for debugging
            $this->log('Google user data: ' . json_encode($userData));

            // Check if user exists
            $email = $googleUser->getEmail();
            if (empty($email)) {
                throw new \RuntimeException('Email not provided by Google');
            }
            
            $this->log('Looking up user by email: ' . $email);
            $utilisateur = $this->utilisateurRepository->findOneBy(['email' => $email]);
            
            if (!$utilisateur) {
                $this->log('User not found, creating new user');
                
                // Create new user
                $utilisateur = new Utilisateur();
                $utilisateur->setEmail($email);
                
                // Get first and last name
                $firstName = $googleUser->getFirstName() ?? 'Google';
                $lastName = $googleUser->getLastName() ?? 'User';
                
                // If first/last name are null, try to extract from full name
                if (($firstName === 'Google' || $lastName === 'User') && isset($userData['name'])) {
                    $nameParts = explode(' ', $userData['name'], 2);
                    if (count($nameParts) > 0) {
                        $firstName = $nameParts[0];
                    }
                    if (count($nameParts) > 1) {
                        $lastName = $nameParts[1];
                    }
                }
                
                $this->log('Setting user data: firstName=' . $firstName . ', lastName=' . $lastName);
                
                // Set user data - ensure values are not null
                $utilisateur->setPrenom($firstName);
                $utilisateur->setNom($lastName);
                $utilisateur->setPassword(password_hash(bin2hex(random_bytes(16)), PASSWORD_BCRYPT)); 
                $utilisateur->setRole('ROLE_USER');
                $utilisateur->setStatutCompte('active');
                
                try {
                    // Manually begin transaction for better error control
                    $this->entityManager->getConnection()->beginTransaction();
                    
                    $this->log('Persisting new user to database');
                    $this->entityManager->persist($utilisateur);
                    $this->entityManager->flush();
                    
                    // Commit the transaction
                    $this->entityManager->getConnection()->commit();
                    
                    $this->log('User successfully persisted with ID: ' . $utilisateur->getId());
                } catch (\Exception $e) {
                    // Roll back the failed transaction
                    if ($this->entityManager->getConnection()->isTransactionActive()) {
                        $this->entityManager->getConnection()->rollBack();
                    }
                    
                    $this->log('Database error: ' . $e->getMessage(), 'error', [
                        'exception' => get_class($e),
                        'message' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                    throw $e;
                }
            } else {
                $this->log('User already exists with ID: ' . $utilisateur->getId());
            }
            
            return $utilisateur;
        } catch (\Exception $e) {
            $this->log('Google callback error: ' . $e->getMessage(), 'error', [
                'exception' => get_class($e),
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw new \RuntimeException('Failed to handle Google callback: ' . $e->getMessage(), 0, $e);
        }
    }
<<<<<<< HEAD
}
=======
>>>>>>> Salles
} 
=======
            $userData = $googleUser->toArray();
            
            // Dump user data for debugging
            $this->log('Google user data: ' . json_encode($userData));

            // Check if user exists
            $email = $googleUser->getEmail();
            if (empty($email)) {
                throw new \RuntimeException('Email not provided by Google');
            }
            
            $this->log('Looking up user by email: ' . $email);
            $utilisateur = $this->utilisateurRepository->findOneBy(['email' => $email]);
            
            if (!$utilisateur) {
                $this->log('User not found, creating new user');
                
                // Create new user
                $utilisateur = new Utilisateur();
                $utilisateur->setEmail($email);
                
                // Get first and last name
                $firstName = $googleUser->getFirstName() ?? 'Google';
                $lastName = $googleUser->getLastName() ?? 'User';
                
                // If first/last name are null, try to extract from full name
                if (($firstName === 'Google' || $lastName === 'User') && isset($userData['name'])) {
                    $nameParts = explode(' ', $userData['name'], 2);
                    if (count($nameParts) > 0) {
                        $firstName = $nameParts[0];
                    }
                    if (count($nameParts) > 1) {
                        $lastName = $nameParts[1];
                    }
                }
                
                $this->log('Setting user data: firstName=' . $firstName . ', lastName=' . $lastName);
                
                // Set user data - ensure values are not null
                $utilisateur->setPrenom($firstName);
                $utilisateur->setNom($lastName);
                $utilisateur->setPassword(password_hash(bin2hex(random_bytes(16)), PASSWORD_BCRYPT)); 
                $utilisateur->setRole('ROLE_USER');
                $utilisateur->setStatutCompte('active');
                
                try {
                    // Manually begin transaction for better error control
                    $this->entityManager->getConnection()->beginTransaction();
                    
                    $this->log('Persisting new user to database');
                    $this->entityManager->persist($utilisateur);
                    $this->entityManager->flush();
                    
                    // Commit the transaction
                    $this->entityManager->getConnection()->commit();
                    
                    $this->log('User successfully persisted with ID: ' . $utilisateur->getId());
                } catch (\Exception $e) {
                    // Roll back the failed transaction
                    if ($this->entityManager->getConnection()->isTransactionActive()) {
                        $this->entityManager->getConnection()->rollBack();
                    }
                    
                    $this->log('Database error: ' . $e->getMessage(), 'error', [
                        'exception' => get_class($e),
                        'message' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                    throw $e;
                }
            } else {
                $this->log('User already exists with ID: ' . $utilisateur->getId());
            }
            
            return $utilisateur;
        } catch (\Exception $e) {
            $this->log('Google callback error: ' . $e->getMessage(), 'error', [
                'exception' => get_class($e),
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw new \RuntimeException('Failed to handle Google callback: ' . $e->getMessage(), 0, $e);
        }
    }
}
>>>>>>> 6ab9b1d (Initial commit)
<<<<<<< HEAD
=======
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles
