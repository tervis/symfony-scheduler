<?php
declare(strict_types=1);

namespace App\Tests\Entity;


use App\Entity\Schedule;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class ScheduleTest
 * @package App\Tests\Entity
 */
class ScheduleTest extends KernelTestCase
{
    /**
     * @test
     */
    public function initializes(): void
    {
        $entity = new Schedule();
        self::assertNull($entity->getId());
        self::assertNull($entity->getTaskName());
        self::assertNull($entity->getQueueName());
        self::assertNull($entity->getScheduledAt());
        self::assertNull($entity->getExecutedAt());
        self::assertNull($entity->getDescription());

        self::assertIsArray($entity->getContext());
        self::assertEmpty($entity->getContext());
    }
}