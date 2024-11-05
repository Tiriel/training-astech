<?php

namespace App\DataFixtures;

use App\Entity\Event;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EventFixtures extends Fixture
{
    public const SF_LIVE = 'sf_live_';

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i <= 30; $i++) {
            $year = '20'.str_pad($i, 2, '0', STR_PAD_LEFT);
            $event = (new Event())
                ->setName('SymfonyLive '.$year)
                ->setDescription('Some generic description')
                ->setAccessible(true)
                ->setStartAt(new \DateTimeImmutable('25-03-'.$year))
                ->setEndAt(new \DateTimeImmutable('25-03-'.$year))
            ;
            $manager->persist($event);
            $this->addReference(self::SF_LIVE.$i, $event);
        }

        $manager->flush();
    }
}
