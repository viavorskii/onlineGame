<?php

namespace RPGBundle\Security;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

/**
 * @author Vladislav Iavorskii
 */
class ApiKeyUserProvider implements UserProviderInterface
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getUsernameForApiKey($apiKey, $userId)
    {
        $userRepo = $this->entityManager->getRepository(\RPGBundle\Entity\User::class);
        $username = $userRepo->findBy(["secretKey" => $apiKey, "id" => $userId]);

        return $username;
    }

    public function loadUserByUsername($username)
    {
        return new User(
            $username,
            null,
            array('ROLE_API')
        );
    }

    public function refreshUser(UserInterface $user)
    {
        throw new UnsupportedUserException();
    }

    public function supportsClass($class)
    {
        return User::class === $class;
    }
}