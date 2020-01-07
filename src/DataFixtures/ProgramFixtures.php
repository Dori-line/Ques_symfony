<?php


namespace App\DataFixtures;


use App\Entity\Program;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    const PROGRAMS = [
        'Walking Dead' => [

            'summary' => 'Le policier Rick Grimes se réveille après un long coma. Il découvre avec effarement que le monde, ravagé par une épidémie, est envahi par les morts-vivants.',

            'poster' => 'https://images-na.ssl-images-amazon.com/images/I/61PBPNf7HdL._AC_SY679_.jpg',

            'category' => 'categorie_4',

        ],

        'The Haunting Of Hill House' => [

            'summary' => 'Plusieurs frères et sœurs qui, enfants, ont grandi dans la demeure qui allait devenir la maison hantée la plus célèbre des États-Unis, sont contraints de se réunir pour finalement affronter les fantômes de leur passé.',

            'poster' => 'https://images-na.ssl-images-amazon.com/images/I/41jbkgT-2OL._AC_.jpg',

            'category' => 'categorie_4',

        ],

        'American Horror Story' => [

            'summary' => 'A chaque saison, son histoire. American Horror Story nous embarque dans des récits à la fois poignants et cauchemardesques, mêlant la peur, le gore et le politiquement correct.',

            'poster' => 'https://images-na.ssl-images-amazon.com/images/I/719WYomToBL._SY606_.jpg',

            'category' => 'categorie_4',

        ],

        'Love Death And Robots' => [

            'summary' => 'Un yaourt susceptible, des soldats lycanthropes, des robots déchaînés, des monstres-poubelles, des chasseurs de primes cyborgs, des araignées extraterrestres et des démons assoiffés de sang : tout ce beau monde est réuni dans 18 courts métrages animés déconseillés aux âmes sensibles.',

            'poster' => 'https://media.senscritique.com/media/000018424207/source_big/Love_Death_Robots.jpg',

            'category' => 'categorie_4',

        ],

        'Penny Dreadful' => [

            'summary' => 'Dans le Londres ancien, Vanessa Ives, une jeune femme puissante aux pouvoirs hypnotiques, allie ses forces à celles de Ethan, un garçon rebelle et violent aux allures de cowboy, et de Sir Malcolm, un vieil homme riche aux ressources inépuisables. Ensemble, ils combattent un ennemi inconnu, presque invisible, qui ne semble pas humain et qui massacre la population.',

            'poster' => 'https://images-na.ssl-images-amazon.com/images/I/51%2BBWD04OlL._SX466_.jpg',

            'category' => 'categorie_4',

        ],

        'Fear The Walking Dead' => [

            'summary' => 'La série se déroule au tout début de l épidémie relatée dans la série mère The Walking Dead et se passe dans la ville de Los Angeles, et non à Atlanta. Madison est conseillère dans un lycée de Los Angeles. Depuis la mort de son mari, elle élève seule ses deux enfants : Alicia, excellente élève qui découvre les premiers émois amoureux, et son grand frère Nick qui a quitté la fac et a sombré dans la drogue.',

            'poster' => 'https://m.media-amazon.com/images/M/MV5BYWNmY2Y1NTgtYTExMS00NGUxLWIxYWQtMjU4MjNkZjZlZjQ3XkEyXkFqcGdeQXVyMzQ2MDI5NjU@._V1_.jpg',

            'category' => 'categorie_4',

        ],
    ];
    public function load(ObjectManager $manager)
    {
        $i = 0;
        foreach (self::PROGRAMS as $title => $data){
            $randNumber = rand(0, 4);
            $program = new Program();
            $program->setTitle($title);
            $program->setSummary($data['summary']);
            $program->setPoster($data['poster']);

            $slugify = new Slugify();
            $slug = $slugify->generate($program->getTitle());
            $program->setSlug($slug);

            $program->setCategory($this->getReference("categorie_$randNumber"));
            $this->addReference('program_' . $i, $program);
            $manager->persist($program);
            $i++;
        }

        $manager->flush();
    }

    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return [CategoryFixtures::class];
    }
}
