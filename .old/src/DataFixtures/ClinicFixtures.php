<?php

namespace App\DataFixtures;

use App\Factory\ClinicFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ClinicFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        ClinicFactory::new()->createMany(20);
    }
}
