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

        $admin = new User();
        $admin 
            ->setEmail('admin@ex.com')
            ->setPassword($this->encoder->encodePassword($admin, 'admin'))
            ->setFirstname($faker->firstName)
            ->setLastname($faker->lastName)
            ->setUsername($faker->firstName)
            ->setRoles(['ROLE_ADMIN'])
        ;
        $manager->persist($admin);
        $manager->flush();

        for ($i = 0; $i < 10; $i++) {
            $article = new Article();
            $article->setTitle('Titre')
                    ->setContent('Lorem Ipsum')
                    ->setAuthor('Lucas Corre')
                    ->setCreatedAt(new \DateTime());

            $manager->persist($article);
            $manager->flush();
        }
    }
}
