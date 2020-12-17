<?php
declare(strict_types=1);

namespace App\Scheduler;


use App\Dto\Scheduler\TaskDto;
use App\Entity\Schedule;

/**
 * Class ScheduleFactory
 * @package App\Scheduler
 */
class ScheduleFactory
{
    /**
     * Scheduler new task to queue
     * Task name is same as class name
     *
     * @param TaskDto $taskDto
     * @return Schedule
     */
    public static function create(TaskDto $taskDto): Schedule
    {
        $schedule = (new Schedule())
            ->setTaskName($taskDto->getTaskName())
            ->setQueueName($taskDto->getQueueName())
            ->setDescription($taskDto->getDescription())
            ->setScheduledAt($taskDto->getScheduledAt());

        if (!empty($taskDto->getContext())) {
            foreach ($taskDto->getContext() as $key => $value) {
                $schedule->setContext($key, $value);
            }
        }

        return $schedule;
    }
}