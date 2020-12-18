<?php
declare(strict_types=1);

namespace App\Scheduler;

/**
 * All task should implement TaskMessageInterface to get automatic tagging
 * Tasks will be grouped by a tag app.scheduled_task
 *
 * Interface TaskMessageInterface
 * @package App\Scheduler
 */
interface TaskMessageInterface
{
    /**
     * @param int $id Schedule entity id
     * @return $this
     */
    public function setTask(int $id): self;

    /**
     * @return int Schedule entity id
     */
    public function getTask(): int;

    /**
     * Returns the task name ie. short class name
     *
     * @return string
     */
    public function getClassName(): string;

    /**
     * Returns the task class itself
     *
     * @return $this
     */
    public function getClass(): self;

    /**
     * Task description ie. what task will do
     *
     * @return string
     */
    public function getDescription(): string;

}
