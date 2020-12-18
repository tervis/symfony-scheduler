<?php
declare(strict_types=1);

namespace App\Tests\Scheduler;

use App\Scheduler\Task;
use App\Scheduler\ScheduleFactory;
use PHPUnit\Framework\TestCase;

/**
 * Class ScheduleFactoryTest
 * @package App\Tests\Scheduler
 */
class ScheduleFactoryTest extends TestCase
{

    /**
     * @test
     * @dataProvider scheduleTaskProvider
     * @param Task $task
     */
    public function canCreateSchedule(Task $task): void
    {

        $schedule = ScheduleFactory::create($task);

        self::assertEquals($task->getTaskName(), $schedule->getTaskName());
        self::assertEquals($task->getQueueName(), $schedule->getQueueName());
        self::assertEquals($task->getDescription(), $schedule->getDescription());
        self::assertEquals($task->getScheduledAt(), $schedule->getScheduledAt());

        self::assertEquals($task->getContext(), $schedule->getContext());

    }

    /**
     * @return array[]
     */
    public function scheduleTaskProvider(): array
    {
        $date = new \Datetime();

        return [
            [(new Task())
                ->setTaskName('SampleTaskMessage')
                ->setQueueName('default')
                ->setDescription('sample text here')
                ->setScheduledAt($date)],
            [(new Task())
                ->setTaskName('SampleTaskMessage')
                ->setQueueName('default')
                ->setDescription('sample text here')
                ->setScheduledAt($date)
                ->setContext('sample','text')]
        ];
    }

}