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

    public function save(Event $event, bool $flush = false): void
    {
        $this->getEntityManager()->persist($event);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function searchByName(?string $name = null): iterable
    {
        if (null === $name) {
            return $this->findAll();
        }

        $qb = $this->createQueryBuilder('e');

        return $qb->andWhere($qb->expr()->like('e.name', ':name'))
            ->setParameter('name', sprintf("%%%s%%", $name))
            ->getQuery()
            ->getResult();
    }

    public function findLiveEventsBetweenDates(?\DateTimeImmutable $start = null, ?\DateTimeImmutable $end = null): array
    {
        if (null === $start && null === $end) {
            throw new \InvalidArgumentException('At least one date is required to operate this method.');
        }

        $qb = $this->createQueryBuilder('e');
        $qb->andWhere($qb->expr()->orX(
            $qb->expr()->eq('e.archived', 0),
            $qb->expr()->isNull('e.archived')
        ));

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
