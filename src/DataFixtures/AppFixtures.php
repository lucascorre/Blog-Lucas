<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $faker->seed(0);

        for ($i = 0; $i < 5; $i++) {
        $user = new User();
        $user 
            ->setEmail('user@ex.com')
            ->setPassword($this->encoder->encodePassword($user, 'user'))
            ->setFirstname($faker->firstName)
            ->setLastname($faker->lastName)
            ->setUsername($faker->firstName)
        ;
        $manager->persist($user);
        $manager->flush();
        }

        for ($i = 0; $i < 5; $i++) {
        $admin = new User();
        $admin 
            ->setEmail($faker->email)
            ->setPassword($this->encoder->encodePassword($admin, 'admin'))
            ->setFirstname($faker->firstName)
            ->setLastname($faker->lastName)
            ->setUsername($faker->firstName)
            ->setRoles(['ROLE_ADMIN'])
        ;
        $manager->persist($admin);
        $manager->flush();
        }

        for ($i = 0; $i < 50; $i++) {
            $article = new Article();
            $article->setTitle('Lorem Ipsum')
                    ->setContent($faker->realText())
                    ->setAuthor($faker->firstName)
                    ->setCreatedAt($faker->dateTime);

            $manager->persist($article);
            $manager->flush();
        }
    }
}
