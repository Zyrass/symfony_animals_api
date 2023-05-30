<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Animal;
use App\Entity\Country;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AnimalFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $countries = $manager->getRepository(Country::class)->findAll();
        dump($countries);

        for ($i = 0; $i < 1000; $i++) {
            $animal = new Animal();
            $animal
                ->setName($faker->name())
                ->setAverageLifeDuration($faker->numberBetween(10, 200))
                ->setAverageSize($faker->numberBetween(1, 200))
                ->setPhoneNumber($faker->phoneNumber())
                ->setMartialArt($faker->name())
                ->setCountry($faker->randomElement($countries));
            $manager->persist($animal);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [CountryFixtures::class];
    }
}
