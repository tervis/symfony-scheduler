<?php
declare(strict_types=1);

namespace App\Command\Scheduler;


use App\Scheduler\ScheduleManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class SchedulerListAvailableTasksCommand
 * @package App\Command\Scheduler
 */
class SchedulerListAvailableTasksCommand extends Command
{
    protected static $defaultName = 'scheduler:task:list';

    /**
     * @var ScheduleManager
     */
    private ScheduleManager $scheduleManager;

    /**
     * SchedulerListAvailableTasksCommand constructor.
     * @param ScheduleManager $scheduleManager
     * @param string|null $name
     */
    public function __construct(ScheduleManager $scheduleManager, string $name = null)
    {
        parent::__construct($name);
        $this->scheduleManager = $scheduleManager;
    }

    protected function configure(): void
    {
        $this->setDescription('List available tasks');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $table = (new Table($output))->setHeaders(['Task Name', 'Description']);

        $taskList = $this->scheduleManager->getAvailableTasks();

        foreach ($taskList as $task) {
            $table->addRow([$task->getClassName(), $task->getDescription()]);
        }
        $table->render();

        return Command::SUCCESS;
    }
}