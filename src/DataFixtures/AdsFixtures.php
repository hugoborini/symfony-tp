<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Ads;
use App\Entity\UserProfile;
use App\Entity\Comment;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;

class AdsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $roles = ["vendeur", "acheteurs", "admins"];
        $tags = ["voiture", "electronique", "vetement", "high-tech", "meuble"];
        $filesystem = new Filesystem();
        $faker = \Faker\Factory::create();

        for ($i = 0 ; $i < 4; $i++){
            $user = new UserProfile();

            $user->setUsername($faker->name())
                 ->setEmail($faker->email())
                 ->setPassword(md5("test"))
                 ->setRole($roles[array_rand($roles)])
                 ->setVote($faker->numberBetween(0, 5));

            $manager->persist($user);



            for($y = 0; $y < mt_rand(2, 5); $y++){
                $ads = new Ads();
                $ads->setTitle($faker->sentence())
                    ->setDescription($faker->paragraph())
                    ->setPrice($faker->numberBetween(30, 300))
                    ->setDate($faker->dateTimeBetween('-4 week', '+1 week'))
                    ->setTag($tags[array_rand($tags)])
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
                        ->setUserId($user);

                $manager->persist($comment);
            }
        }

        $manager->flush();
    }
}
