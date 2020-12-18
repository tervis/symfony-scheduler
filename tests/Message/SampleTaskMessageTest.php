<?php
declare(strict_types=1);

namespace App\Tests\Message;


use App\Message\SampleTaskMessage;

/**
 * All task test should extend AbstractTaskTestCase
 *
 * Class SampleTaskHandlerTest
 * @package App\Tests\Tasks
 */
class SampleTaskMessageTest extends AbstractTaskTestCase
{

    /**
     * @var SampleTaskMessage
     */
    protected $task;

    public function setUp(): void
    {
        parent::setUp();

        $this->task = new SampleTaskMessage();
    }

}