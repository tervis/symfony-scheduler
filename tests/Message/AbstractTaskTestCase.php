<?php
declare(strict_types=1);


namespace App\Tests\Message;


use App\Scheduler\TaskMessageInterface;
use PHPUnit\Framework\TestCase;

/**
 * All task test should extend AbstractTaskTestCase
 *
 * Class AbstractTaskTestCase
 * @package App\Tests\Tasks
 */
class AbstractTaskTestCase extends TestCase
{

    protected $task;

    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function setTaskWorks(): void
    {
        $this->task->setTask(1);
        self::assertEquals(1, $this->task->getTask());
    }

    /**
     * @test
     */
    public function getClassWorks(): void
    {
        $class = $this->task->getClass();

        self::assertInstanceOf(TaskMessageInterface::class, $class);
    }

    /**
     * @test
     */
    public function getClassNameWorks(): void
    {
        $name = (new \ReflectionClass($this->task))->getShortName();

        self::assertEquals($name, $this->task->getClassName());
    }

    /**
     * @test
     */
    public function getDescriptionWorks(): void
    {
        self::assertIsString($this->task->getDescription());
    }
}