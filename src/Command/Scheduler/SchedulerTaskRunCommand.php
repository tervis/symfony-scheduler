<?php
declare(strict_types=1);

namespace App\Command\Scheduler;


use App\Scheduler\ScheduleManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SchedulerTaskRunCommand extends Command
{
    protected static $defaultName = 'scheduler:task:run';

    /**
     * @var ScheduleMAnager
     */
    private ScheduleManager $scheduleManager;

    /**
     * SchedulerRunCommand constructor.
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
        $this
            ->setDescription('Run single tasks directly')
            ->addArgument('task', InputArgument::REQUIRED, 'Task name')
            ->addOption('dry', null, InputOption::VALUE_NONE, 'Option to run dry');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $taskToRun = $input->getArgument('task');
        $dry = $input->getOption('dry');

        $taskList = $this->scheduleManager->getAvailableTasks();

        $message = sprintf('Task (%s) not found!', $taskToRun);

        foreach ($taskList as $task) {
            if ($taskToRun === $task->getClassName()) {
                if ($dry) {
                    $message = sprintf('Running DRY task: %s', $task->getClassName());
                } else {
                    $message = sprintf('Running task: %s', $task->getClassName());
                    $task->run();
                }
                break; //breaks loop if match
            }
        }

        $output->writeln($message);

        return Command::SUCCESS;
    }
}