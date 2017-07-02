<?php

namespace Tests\RPGBundle\Service;

use Doctrine\ORM\EntityManager;
use RPGBundle\Entity\Fight;
use RPGBundle\Entity\User;
use RPGBundle\Event\FightEvent;
use RPGBundle\Repository\FightRepository;
use RPGBundle\Service\EventFactory;
use RPGBundle\Service\ExploreService;
use RPGBundle\Service\Fight\SimpleFightService;
use RPGBundle\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @author Vladislav Iavorskii
 */
class ExploreServiceTest extends KernelTestCase
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

    public function testStepWithoutActualFight()
    {
        $user = $this->createMock(User::class);
        $entityManager = $this->createMock(EntityManager::class);

        $userService = $this
            ->getMockBuilder(UserService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $userService->expects($this->once())
            ->method('get')
            ->will($this->returnValue($user));
        $userService->expects($this->once())
            ->method("getActualFight")
            ->will($this->returnValue(null));

        $fightEvent = $this
            ->getMockBuilder(FightEvent::class)
            ->disableOriginalConstructor()
            ->getMock();

        $fightEvent->expects($this->once())
            ->method("run")
            ->will($this->returnValue($fightEvent));

        $eventFactory = $this
            ->getMockBuilder(EventFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $eventFactory->expects($this->once())
            ->method('create')
            ->will($this->returnValue($fightEvent));

        $exploreService = new ExploreService($entityManager, $userService, $eventFactory, []);
        $returnValue = $exploreService->step(1);

        $this->assertEquals($fightEvent, $returnValue);
    }

    public function testFight()
    {
        $user = $this->createMock(User::class);
        $fight = $this->createMock(Fight::class);
        $fightEvent = $this->createMock(FightEvent::class);
        $fightRepo = $this->createMock(FightRepository::class);
        $fightRepo
            ->expects($this->once())
            ->method("get")
            ->will($this->returnValue($fight));

        $userService = $this
            ->getMockBuilder(UserService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $userService->expects($this->once())
            ->method('get')
            ->will($this->returnValue($user));


        $entityManager = $this
            ->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $entityManager->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($fightRepo));


        $eventFactory = $this
            ->getMockBuilder(EventFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $eventFactory->expects($this->once())
            ->method('createFightEvent')
            ->will($this->returnValue($fightEvent));

        $exploreService = new ExploreService($entityManager, $userService, $eventFactory, []);
        $return = $exploreService->fight(1, 1, SimpleFightService::FIGHT_ACTION_FIGHT);

        $this->assertEquals($fightEvent, $return);
    }
}