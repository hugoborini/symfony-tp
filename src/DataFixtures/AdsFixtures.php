<?php

namespace App\DataFixtures;

use App\Entity\Ads;
use App\Entity\Comment;
use App\Entity\Category;
use App\Entity\UserProfile;
use Symfony\Component\Filesystem\Path;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;


class AdsFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        $roles = ["ROLE_USER", "ROLE_ADMIN"];

        $tags = ["Vacances", "Emploi", "Véhicules", "Immobilier", "Mode", "Maison", "Multimédia", "Loisirs", "Animaux", "Matériel Professionnel",
        "Services",
        "Divers"];
        $categoryObjectTab = [];
        $filesystem = new Filesystem();
        $faker = \Faker\Factory::create();


        foreach ($tags as $tag) {
            $category = new Category();

            $category->setCategoryName($tag);

            $manager->persist($category);

            array_push($categoryObjectTab, $category);

        }

        for ($i = 0 ; $i < 4; $i++){
            $user = new UserProfile();

            $user->setUsername($faker->name())
                 ->setEmail($faker->email())
                 ->setPassword("test")
                 ->setRole($roles[array_rand($roles)])
                 ->setVote($faker->numberBetween(0, 5));



            $manager->persist($user);



            for($y = 0; $y < mt_rand(2, 5); $y++){
                $ads = new Ads();
                $ads->setTitle($faker->sentence())
                    ->setDescription($faker->paragraph())
                    ->setPrice($faker->numberBetween(30, 300))
                    ->setDate($faker->dateTimeBetween('-4 week', '+1 week'))
                    ->setCategoryID($categoryObjectTab[array_rand($categoryObjectTab)])
                    ->setImage("oui")
                    ->setUserID($user);


                $manager->persist($ads);
                $manager->flush();

                $filesystem->mkdir("public/image/" . $ads->getID(), 0700);
                $filesystem->copy("public/image/baseimage/base.png", "public/image/" . $ads->getID() . "/base.png");

            }

            for($j = 0; $j < mt_rand(5, 9); $j++){
                $comment = new Comment();

                $comment->setText($faker->text())
                        ->setDate($faker->dateTimeBetween('-4 week', '+1 week'))
                        ->setUserId($user)
                        ->setAdsID($ads);

                $manager->persist($comment);
            }
        }

        $manager->flush();
    }
}
