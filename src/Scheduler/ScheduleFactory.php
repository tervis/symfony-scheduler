<?php
declare(strict_types=1);

namespace App\Scheduler;


use App\Entity\Schedule;

/**
 * Class ScheduleFactory
 * @package App\Scheduler
 */
class ScheduleFactory
{
    /**
     * Schedule a new task to queue
     * Task name is same as class name
     *
     * @param Task $task
     * @return Schedule
     */
    public static function create(Task $task): Schedule
    {
        $schedule = (new Schedule())
            ->setTaskName($task->getTaskName())
            ->setQueueName($task->getQueueName())
            ->setDescription($task->getDescription())
            ->setScheduledAt($task->getScheduledAt());

        if (!empty($task->getContext())) {
            foreach ($task->getContext() as $key => $value) {
                $schedule->setContext($key, $value);
            }
        }

        return $schedule;
    }
}