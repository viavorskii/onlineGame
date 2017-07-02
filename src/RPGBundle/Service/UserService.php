<?php

namespace RPGBundle\Service;

use Doctrine\ORM\EntityManager;
use RPGBundle\Entity\Fight;
use RPGBundle\Entity\Interfaces\FightInterface;
use RPGBundle\Entity\Role;
use RPGBundle\Entity\User;
use RPGBundle\Exception\UserException;
use RPGBundle\Service\Fight\AbstractFightService;

/**
 * @author Vladislav Iavorskii
 */
class UserService
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    public function createUser($name, $roleId, $password) : User
    {
        $roleRepo = $this->entityManager->getRepository(Role::class);
        $role = $roleRepo->find($roleId);
        if ($role) {
            $userRepo = $this->entityManager->getRepository(User::class);
            $userExists = $userRepo->findOneBy(["name" => $name]);
            if (!$userExists) {

                $encodedPassword = $this->encodePassword($password);
                $secretKey = $this->generateSecretKey($password, $name);
                $user = $userRepo->create($name, $role, $encodedPassword, $secretKey);
            } else {
                throw new UserException("User {$name} already exists");
            }
        } else {
            throw new UserException("Role {$roleId} is not found");
        }

        return $user;
    }

    public function get($id) : User
    {
        $userRepo = $this->entityManager->getRepository(User::class);
        $user = $userRepo->find($id);
        if (!$user) {
            throw new UserException("User is not found");
        }

        return $user;
    }


    /**
     * @param User $user
     * @return FightInterface|false
     */
    public function getActualFight(User $user)
    {
        $fightRepo = $this->entityManager->getRepository(Fight::class);
        $fights = $fightRepo->findBy(["status" => AbstractFightService::STATUS_FIGHT_WAIT, "user" => $user]);

        return reset($fights);
    }
    
    public function getRoles() : array
    {
        $roleRepo = $this->entityManager->getRepository(Role::class);
        $roles = $roleRepo->findAll();

        return $roles;
    }

    public function getUserByPassword($nickname, $password)
    {
        $encodedPassword = $this->encodePassword($password);
        $userRepo = $this->entityManager->getRepository(User::class);
        $user = $userRepo->findOneBy(["name" => $nickname, "password" => $encodedPassword]);

        return $user;
    }
    private function encodePassword($password)
    {
        return crypt($password, time());
    }

    private function generateSecretKey($password, $nickname)
    {
        return password_hash($password . $nickname . time() , PASSWORD_DEFAULT);
    }
    
}