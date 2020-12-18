<?php
declare(strict_types=1);

namespace App\Tests\MessageHandler;


use App\Entity\Schedule;
use App\Message\SampleTaskMessage;
use App\MessageHandler\SampleTaskMessageHandler;
use App\Repository\ScheduleRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;


/**
 * All task test should extend AbstractTaskTestCase
 *
 * Class SampleTaskHandlerTest
 * @package App\Tests\Tasks
 */
class SampleTaskMessageHandlerTest extends TestCase
{

    /**
     * @var SampleTaskMessageHandler
     */
    private $handler;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|LoggerInterface
     */
    private $logger;

    /**
     * @var EntityManagerInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    private $em;

    /**
     * @var ScheduleRepository|\PHPUnit\Framework\MockObject\MockObject
     */
    private $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->logger = $this->createMock(LoggerInterface::class);
        $this->em = $this->createMock(EntityManagerInterface::class);
        $this->repository = $this->createMock(ScheduleRepository::class);

        $this->handler = new SampleTaskMessageHandler($this->em, $this->repository);
        $this->handler->setLogger($this->logger);
    }

    /**
     * @test
     */
    public function runWorks(): void
    {
        $schedule = (new Schedule())->setTaskName('SampleMessage')
            ->setQueueName('default')
            ->setDescription('sample text here')
            ->setScheduledAt(new \DateTime('-2 min'));

        /** @var SampleTaskMessage $message */
        $message = (new SampleTaskMessage())->setTask(1);

        $this->logger->expects($this->once())
            ->method('info');

        $this->em->expects($this->once())
            ->method('flush');

        $this->repository->expects($this->once())
            ->method('find')
            ->willReturn($schedule);

        $this->handler->__invoke($message);

        self::assertNotNull($schedule->getExecutedAt());
    }
}