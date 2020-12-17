<?php
declare(strict_types=1);


namespace App\Tests\Tasks;


use App\Scheduler\TaskInterface;
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
    public function getClassWorks(): void
    {
        $class = $this->task->getClass();

        self::assertInstanceOf(TaskInterface::class, $class);
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