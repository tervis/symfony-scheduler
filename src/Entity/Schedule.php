<?php
declare(strict_types=1);

namespace App\Entity;


use App\Entity\Traits\ContextTrait;
use App\Repository\ScheduleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Task scheduled to run
 * @ORM\Entity(repositoryClass=ScheduleRepository::class)
 * Class Scheduler
 * @package App\Entity
 */
class Schedule
{
    use ContextTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Task name is same as Task class name
     *
     * @ORM\Column(type="string", length=255)
     */
    private $taskName;

    /**
     * Queue name
     *
     * @ORM\Column(type="string", length=80)
     */
    private $queueName;

    /**
     * Scheduled time to run task
     *
     * @ORM\Column(type="datetime")
     */
    private $scheduledAt;

    /**
     * Task execution time
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $executedAt;

    /**
     * Short description what will happen
     *
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getTaskName(): ?string
    {
        return $this->taskName;
    }

    /**
     * @param string $taskName
     * @return $this
     */
    public function setTaskName(string $taskName): self
    {
        $this->taskName = $taskName;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getScheduledAt(): ?\DateTimeInterface
    {
        return $this->scheduledAt;
    }

    /**
     * @param \DateTimeInterface $scheduledAt
     * @return $this
     */
    public function setScheduledAt(\DateTimeInterface $scheduledAt): self
    {
        $this->scheduledAt = $scheduledAt;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getExecutedAt(): ?\DateTimeInterface
    {
        return $this->executedAt;
    }

    /**
     * @param \DateTimeInterface|null $executedAt
     * @return $this
     */
    public function setExecutedAt(?\DateTimeInterface $executedAt): self
    {
        $this->executedAt = $executedAt;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getQueueName(): ?string
    {
        return $this->queueName;
    }

    /**
     * @param string $queueName
     * @return $this
     */
    public function setQueueName(string $queueName): self
    {
        $this->queueName = $queueName;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

}
