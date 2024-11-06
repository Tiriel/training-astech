<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Event>
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function findEventsBetweenDates(?\DateTimeImmutable $start = null, ?\DateTimeImmutable $end = null): array
    {
        if (null === $start && null === $end) {
            throw new \InvalidArgumentException('At least one date is required to operate this method.');
        }

        $qb = $this->createQueryBuilder('e');

        if ($start instanceof \DateTimeImmutable) {
            $qb->andWhere('e.startAt >= :start')
                ->setParameter('start', $start);
        }

        if ($end instanceof \DateTimeImmutable) {
            $qb->andWhere('e.endAt <= :end')
                ->setParameter('end', $end);
        }

        return $qb->getQuery()->getResult();
    }
}
