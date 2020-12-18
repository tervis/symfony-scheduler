<?php
declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\SampleTaskMessage;
use App\Repository\ScheduleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * Class SampleTaskMessageHandler
 * @package App\MessageHandler
 */
final class SampleTaskMessageHandler implements MessageHandlerInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var ScheduleRepository
     */
    private $repository;

    /**
     * SampleMessageHandler constructor.
     * @param EntityManagerInterface $em
     * @param ScheduleRepository $repository
     */
    public function __construct(EntityManagerInterface $em, ScheduleRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    /**
     * @param SampleTaskMessage $message
     */
    public function __invoke(SampleTaskMessage $message)
    {
        $id = $message->getTask();
        $schedule = $this->repository->find($id);

        if (!$schedule) {
            // could throw an exception... it would be retried
            // or return and this message will be discarded
            if ($this->logger) {
                $this->logger->alert(sprintf('Schedule (%s) was missing!', (string)$id));
            }
            return;
        }
        // do something with your message
        $this->logger->info(sprintf('SampleTaskHandler called at: %s with id (%d)', date('H:i:s'), $id));
        $schedule->setExecutedAt(new \DateTime());
        $this->em->flush();
    }
}
