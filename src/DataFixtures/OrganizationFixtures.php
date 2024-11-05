<?php

namespace App\DataFixtures;

use App\Entity\Organization;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class OrganizationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $org = (new Organization())
            ->setName('Symfony')
            ->setPresentation('The Symfony Organization')
            ->setCreatedAt(new \DateTimeImmutable())
        ;

        for ($i = 12; $i < 22; $i++) {
            $org->addEvent($this->getReference(EventFixtures::SF_LIVE.$i));
        }

        $manager->persist($org);
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            EventFixtures::class,
        ];
    }
}
