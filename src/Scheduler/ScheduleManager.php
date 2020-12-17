<?php
declare(strict_types=1);

namespace App\Scheduler;


use App\Dto\Scheduler\TaskDto;
use App\Entity\Schedule;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

/**
 * Class ScheduleManager
 * @package App\Scheduler
 */
class ScheduleManager implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    protected iterable $availableTasks;

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    public function __construct(\Traversable $availableTasks, EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->availableTasks = $availableTasks;
    }

    /**
     * Schedule a new runnable task
     *
     * @param TaskDto $taskDto
     */
    public function scheduleTask(TaskDto $taskDto): void
    {
        $task = ScheduleFactory::create($taskDto);
        $this->em->persist($task);
        $this->em->flush();
    }

    /**
     * //@TODO handle errors
     * Removes task from schedule
     * @param Schedule $schedule
     */
    public function removeTaskFromSchedule(Schedule $schedule): void
    {
        try {
            $this->em->remove($schedule);
        } catch (\Throwable $e) {
            $this->logger->error(__METHOD__ . ' Unable to remove scheduled task');
        }
    }

    /**
     * Finds scheduled tasks from repository by queueName and <= now
     * @TODO queueName
     *
     * @param string|null $queueName Optional queue name
     * @return mixed
     */
    public function getSchedule(?string $queueName = null)
    {
        $repo = $this->em->getRepository(Schedule::class);
        return $repo->findTaskQueue($queueName);
    }

    /**
     * Returns available tasks as array
     *
     * @return array
     */
    public function getAvailableTasks(): array
    {
        return iterator_to_array($this->availableTasks);
    }

    /**
     * Sets task execution time to Schedule object
     *
     * @param Schedule $schedule
     */
    public function setTaskExecutedAt(Schedule $schedule): void
    {
        $schedule->setExecutedAt(new \DateTime());
        $this->em->flush();
    }
}