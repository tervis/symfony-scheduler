<?php
declare(strict_types=1);


namespace App\Tasks;


use App\Scheduler\TaskInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

/**
 * All task should implement TaskInterface to get automatic tagging
 * Tasks will be grouped by a tag app.scheduled_task
 *
 * Class SampleTask
 * @package App\Tasks
 */
class SampleTask implements TaskInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    /**
     * Returns this class short name ie. SampleTask
     * @return string
     */
    public function getClassName(): string
    {
        return (new \ReflectionClass($this))->getShortName();
    }

    /**
     * Returns the task class itself
     *
     * @return $this
     */
    public function getClass(): TaskInterface
    {
        return $this;
    }

    /**
     * Task description ie. what task will do
     *
     * @return string
     */
    public function getDescription(): string
    {
        return 'For sample use only';
    }

    /**
     * Execute the task
     */
    public function run()
    {
        $this->logger->info('SampleTask called at: ' . date('H:i:s'));
    }

}