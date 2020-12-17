<?php
declare(strict_types=1);

namespace App\Tests\Scheduler;


use App\Scheduler\ScheduleManager;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

/**
 * Class ScheduleServiceTest
 * @package App\Tests\Scheduler
 */
class ScheduleManagerTest extends TestCase
{
    /**
     * @var ScheduleManager
     */
    private $service;

    private $availableTasks;

    /**
     * @var EntityManagerInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    private $em;

    public function setUp(): void
    {
        parent::setUp();

        $this->em = $this->createMock(EntityManagerInterface::class);
        $this->availableTasks = $this->createMock(\Iterator::class); //iterable objects list

        $this->service = new ScheduleManager($this->availableTasks, $this->em);
        $this->service->setLogger($this->createMock(LoggerInterface::class));
    }

    /**
     * @test
     */
    public function getAvailableTasksWorks(): void
    {
        $taskList = $this->service->getAvailableTasks();

        self::assertIsArray($taskList);
    }
}
