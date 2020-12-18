<?php
declare(strict_types=1);

namespace App\Scheduler;


use Symfony\Component\Validator\Constraints as Assert;

/**
 * @TODO data validation
 * Task data transfer object
 * Class TaskDto
 * @package App\Dto\Scheduler
 */
class Task
{
    /**
     * Task name is same as Task class name
     *
     * @Assert\NotNull()
     * @Assert\NotBlank()
     * @var string
     */
    private $taskName;

    /**
     * @Assert\NotNull()
     * @Assert\NotBlank()
     * @var string
     */
    private $queueName;

    /**
     * Scheduled time to run task
     *
     * @Assert\Type(type="datetime")
     * @var \DateTime
     */
    private $scheduledAt;

    /**
     * @Assert\Type(type="datetime")
     * @var \DateTime
     */
    private $executedAt;

    /**
     * @Assert\Type(type="string")
     * @Assert\NotNull()
     * @Assert\NotBlank()
     * @var string
     */
    private $description;

    /**
     * @var array
     */
    private $context = [];

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

    /**
     * @return \DateTime|null
     */
    public function getScheduledAt(): ?\DateTime
    {
        return $this->scheduledAt;
    }

    /**
     * @param \DateTime $scheduledAt
     * @return $this
     */
    public function setScheduledAt(\DateTime $scheduledAt): self
    {
        $this->scheduledAt = $scheduledAt;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getExecutedAt(): ?\DateTime
    {
        return $this->executedAt;
    }

    /**
     * @param \DateTime $executedAt
     * @return $this
     */
    public function setExecutedAt(\DateTime $executedAt): self
    {
        $this->executedAt = $executedAt;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @param string|null $key
     * @param string|null $default
     * @return mixed
     */
    public function getContext(?string $key = null, $default = null)
    {
        if ($key === null) {
            return $this->context;
        }
        return $this->context[$key] ?? $default;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function setContext(string $key, $value): self
    {
        $this->context[$key] = $value;

        return $this;
    }

}