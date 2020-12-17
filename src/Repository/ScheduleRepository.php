<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Schedule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Schedule|null find($id, $lockMode = null, $lockVersion = null)
 * @method Schedule|null findOneBy(array $criteria, array $orderBy = null)
 * @method Schedule[]    findAll()
 * @method Schedule[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ScheduleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Schedule::class);
    }

    /**
     * Find tasks from schedule where scheduled at is les or equal to current time
     * and executed at is null
     *
     * @param string|null $queueName Optional queue name, included if not null
     * @return int|mixed|string
     */
    public function findTaskQueue(?string $queueName = null)
    {
        $dateTime = new \Datetime();

        $qb = $this->createQueryBuilder('s')
            ->andWhere('s.executedAt IS NULL')
            ->andWhere('s.scheduledAt <= :val')
            ->setParameter('val', $dateTime);

        if ($queueName) {
            $qb->andWhere('s.queueName = :name')->setParameter('name', $queueName);
        }

        return $qb->orderBy('s.scheduledAt', 'ASC')->getQuery()->getResult();
    }

}
