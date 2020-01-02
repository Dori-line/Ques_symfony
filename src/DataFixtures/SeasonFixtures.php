<?php


namespace App\DataFixtures;


use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i= 0; $i < 50; $i++) {
            $randNumber = rand(0,5);
            $season = new Season();
            $season->setNumber($faker->randomDigit);
            $season->setYear($faker->year);
            $season->setDescription($faker->text);
            $this->addReference('season_' . $i, $season);
            $season->setProgram($this->getReference("program_$randNumber"));
            $manager->persist($season);
        }


        $manager->flush();

    }

    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return [ProgramFixtures::class];
    }
}
