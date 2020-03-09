<?php

namespace App\DataFixtures;

use App\Entity\Illustration;
use App\Entity\Post;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
const N_POST = 10;
const CATEGORY =['Monde','Société','Politique','Culturel','Tech&internet','Médias','Boire & manger','Sciences','Santé','Santé'];

    public function load(ObjectManager $manager)
    {
        $this->loadIllustration($manager);
        $this->loadCategory($manager);
        $this->loadPost($manager);

    }
    /**
     * Alimenter l'entité Illustration.
     */
    public function loadIllustration(ObjectManager $manager)
    {
        // 20 images
        // On configure faker pour distribuer des données en francais
        $faker = Faker\Factory::create('fr_FR');
        $faker->addProvider(new \EmanueleMinotto\Faker\PlaceholdItProvider($faker));
        for ($i = 1; $i <= self::N_POST; $i++) {
            // créer une entité Illustration
            $illustration = new Illustration();
            $illustration->setName($faker->imageUrl('200x200'))
                ->setDescription($faker->sentence());
            // persister
            $manager->persist($illustration);
            // référencer l'illustration
            $this->addReference('image-' . $i, $illustration);
        }
        $manager->flush();
    }

    /**
     * Alimenter l'entité Post.
     */
    public function loadPost(ObjectManager $manager)
    {
        // 20 articles
        // On configure faker pour distribuer des données en francais
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 1; $i <= self::N_POST; $i++) {
            $post = new Post();
            // le titre avec entre 4 et 10 mots
            // le contenu de l'article entre 10 et 100 phrases
            $post->setTitle($faker->sentence($faker->numberBetween(4, 10)))
                ->setBody($faker->paragraph($faker->numberBetween(10, 100)))
                ->setPublishedAt($faker->dateTimeInInterval('-20 days', '+10 days'))
                ->setIllustration($this->getReference('image-' . $i))
                ->setCategory( $this->getReference('cat-' . $faker->numberBetween(0,count(self::CATEGORY)-1)) );
            $manager->persist($post);
        }
        $manager->flush();
    }


    /**
     * Alimenter l'entité Catégorie.
     */
    public function loadCategory(ObjectManager $manager)
    {
        for ($i = 0; $i < count(self::CATEGORY); $i++) {

            $category = new Category();

            $category->setDescription(self::CATEGORY[$i]);
            $manager->persist($category);
                        // référencer à la cat
            $this->addReference('cat-' . $i, $category);
        }

        $manager->flush();
    }
}
