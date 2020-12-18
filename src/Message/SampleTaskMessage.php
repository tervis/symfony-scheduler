<?php
declare(strict_types=1);

namespace App\Message;


use App\Scheduler\TaskMessageInterface;

/**
 * Class SampleTaskMessage
 * @package App\Message
 */
final class SampleTaskMessage implements TaskMessageInterface
{
    /*
     * Add whatever properties & methods you need to hold the
     * data for this message class.
     */

    /**
     * @var int Task id
     */
    private $task;
//
//     public function __construct(string $name)
//     {
//         $this->name = $name;
//     }
//
//    public function getName(): string
//    {
//        return $this->name;
//    }

    /**
     * @param int $id
     * @return TaskMessageInterface
     */
    public function setTask(int $id): TaskMessageInterface
    {
        $this->task = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getTask(): int
    {
        return $this->task;
    }

    /**
     * Returns the task name ie. short class name
     *
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
    public function getClass(): TaskMessageInterface
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
        return 'SampleTaskMessage description';
    }

}
