<?php
declare(strict_types=1);

namespace App\Tests\Command\Scheduler;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class SchedulerRunCommandTest
 * @package App\Tests\Command\Scheduler
 */
class SchedulerRunCommandTest extends KernelTestCase
{
    /**
     * @test
     */
    public function dryExecuteWorks(): void
    {
        $kernel = static::createKernel();
        $application = new Application($kernel);

        $command = $application->find('scheduler:run');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            // pass arguments to the helper
            '--dry' => 1,

            // prefix the key with two dashes when passing options,
            // e.g: '--some-option' => 'option_value',
        ]);

        // the output of the command in the console
        $output = $commandTester->getDisplay();
        self::assertStringContainsString('Task Name', $output);
        self::assertStringContainsString('Scheduled At',$output);

    }
}