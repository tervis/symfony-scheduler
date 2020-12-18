<?php
declare(strict_types=1);

namespace App\Command\Scheduler;


use App\Entity\Schedule;
use App\Scheduler\ScheduleManager;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Run scheduled tasks
 *
 * Class SchedulerRunCommand
 * @package App\Command
 */
class SchedulerRunCommand extends Command implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    use LockableTrait;

    protected static $defaultName = 'scheduler:run';

    /**
     * @var ScheduleManager
     */
    private $scheduleManager;

    /**
     * @var MessageBusInterface
     */
    private $bus;

    /**
     * SchedulerRunCommand constructor.
     * @param ScheduleManager $scheduleManager
     * @param MessageBusInterface $bus
     * @param string|null $name
     */
    public function __construct(ScheduleManager $scheduleManager, MessageBusInterface $bus, string $name = null)
    {
        parent::__construct($name);
        $this->scheduleManager = $scheduleManager;
        $this->bus = $bus;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Run scheduled tasks')
            ->addArgument('task', InputArgument::OPTIONAL, 'Task name')
            ->addOption('dry', null, InputOption::VALUE_NONE, 'Option to run dry');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!$this->lock()) {
            $output->writeln('The command is already running in another process.');

            return Command::SUCCESS;
        }

        $dry = $input->getOption('dry');

        $schedule = $this->scheduleManager->getSchedule();

        if (empty($schedule)) {
            $output->writeln('Nothing to run');
            return Command::SUCCESS;
        }

        if ($dry) {
            $table = (new Table($output))->setHeaders(['Task Name', 'Scheduled At', 'Desc']);
            foreach ($schedule as $scheduledTask) {
                $table->addRow([$scheduledTask->getTaskName(), $scheduledTask->getScheduledAt()->format('Y/m/d h:m'), $scheduledTask->getDescription()]);
            }
            $table->render();
        } else {
            foreach ($schedule as $scheduledTask) {
                $this->runTask($scheduledTask);
            }
            $output->writeln('done');
        }

        return Command::SUCCESS;
    }

    /**
     * Try run task and set schedule executedAt time if success
     *
     * @param Schedule $schedule
     */
    private function runTask(Schedule $schedule): void
    {
        $name = $schedule->getTaskName();
        $taskList = $this->scheduleManager->getAvailableTasks();

        foreach ($taskList as $task) {
            if ($name === $task->getClassName()) {
                try {
                    $message = $task->getClass();
                    $message->setTask($schedule->getId());
                    $this->bus->dispatch($message);
                } catch (\Throwable $e) {
                    $this->logger->error(__METHOD__, ['error' => $e->getMessage()]);
                }
                break; //breaks loop if match
            }
        }
    }

}
