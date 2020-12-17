<?php
declare(strict_types=1);

namespace App\Tests\Tasks;


use App\Tasks\SampleTask;
use Psr\Log\LoggerInterface;


/**
 * All task test should extend AbstractTaskTestCase
 *
 * Class SampleTaskTest
 * @package App\Tests\Tasks
 */
class SampleTaskTest extends AbstractTaskTestCase
{

    /**
     * @var SampleTask
     */
    protected $task;

    private $logger;

    public function setUp(): void
    {
        parent::setUp();

        $this->logger = $this->createMock(LoggerInterface::class);
        $this->task = new SampleTask();
        $this->task->setLogger($this->logger);
    }

    /**
     * @test
     */
    public function runWorks(): void
    {
        $this->logger->expects($this->once())
            ->method('info');

        $this->task->run();
    }
}