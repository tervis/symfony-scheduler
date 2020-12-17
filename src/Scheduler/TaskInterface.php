<?php
declare(strict_types=1);

namespace App\Scheduler;

/**
 * All task should implement TaskInterface to get automatic tagging
 * Tasks will be grouped by a tag app.scheduled_task
 *
 * Interface TaskInterface
 * @package App\Scheduler
 */
interface TaskInterface
{
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

    /**
     * Execute the task
     *
     * @return mixed
     */
    public function run();

}