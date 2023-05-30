<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Country;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CountryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 100; $i++) {
            $country = new Country();
            $country
                ->setName($faker->name())
                ->setISOCode($faker->countryCode());
            $manager->persist($country);
        }
        $manager->flush();
    }
}
