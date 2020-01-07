<?php


namespace App\DataFixtures;


use App\Entity\Episode;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class EpisodesFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 1; $i <= 50; $i++){
            $randNumber = rand(0, 49);
            $episode = new Episode();
            $episode->setSeason($this->getReference('season_' . $randNumber));
            $episode->setTitle($faker->title);
            $episode->setNumber($faker->randomDigit);
            $episode->setSynopsis($faker->text);

            $slugify = new Slugify();
            $slug = $slugify->generate($episode->getTitle());
            $episode->setSlug($slug);

            $manager->persist($episode);
        }

        $manager->flush();

    }

    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return [SeasonFixtures::class];
    }

}
