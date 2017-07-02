<?php

namespace Tests\RPGBundle\Service;

use Doctrine\ORM\EntityManager;
use RPGBundle\Entity\Fight;
use RPGBundle\Entity\User;
use RPGBundle\Event\FightEvent;
use RPGBundle\Service\EventFactory;
use RPGBundle\Service\ExploreService;
use RPGBundle\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @author Vladislav Iavorskii
 */
class SimpleFightServiceTest extends KernelTestCase
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setUp()
    {
        self::bootKernel();

        $this->container = self::$kernel->getContainer();
    }
    public function testStepWithActualFight()
    {
        $user = $this->createMock(User::class);
        $fight = $this->createMock(Fight::class);
        $entityManager = $this->createMock(EntityManager::class);
        $actualFightEvent = $this->createMock(FightEvent::class);

        $userService = $this
            ->getMockBuilder(UserService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $userService->expects($this->once())
            ->method('get')
            ->will($this->returnValue($user));
        $userService->expects($this->once())
            ->method("getActualFight")
            ->will($this->returnValue($fight));


        $eventFactory = $this
            ->getMockBuilder(EventFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $eventFactory->expects($this->once())
            ->method('create')
            ->will($this->returnValue($actualFightEvent));

        $exploreService = new ExploreService($entityManager, $userService, $eventFactory, []);
        $returnValue = $exploreService->step(1);
        $this->assertEquals($actualFightEvent, $returnValue);
    }
}