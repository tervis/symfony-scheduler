<?php
declare(strict_types=1);


namespace App\Tests\Dto\Scheduler;


use App\Dto\Scheduler\TaskDto;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @TODO test validation
 *
 * Class TaskDtoTest
 * @package App\Tests\Dto\Scheduler
 */
class TaskDtoTest extends KernelTestCase
{
    /**
     * @var object|ValidatorInterface|null
     */
    private $validator;

    public function setUp(): void
    {
        parent::setUp();
        static::bootKernel();
        $this->validator = self::$container->get('debug.validator');
    }

    /**
     * @test
     */
    public function shouldInitialize(): void
    {
        $dto = new TaskDto();

        self::assertNull($dto->getTaskName());
        self::assertNull($dto->getQueueName());
        self::assertNull($dto->getDescription());
        self::assertNull($dto->getScheduledAt());
        self::assertNull($dto->getExecutedAt());

        self::assertIsArray($dto->getContext());
        self::assertEmpty($dto->getContext());
    }
}