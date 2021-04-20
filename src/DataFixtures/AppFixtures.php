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

        $userAdmin = new User();
        $userAdmin->setEmail('admin@ex.com');
        $userAdmin->setPassword($this->encoder->encodePassword($userAdmin, 'admin'));
        $userAdmin->setFirstname($faker->firstName);
        $userAdmin->setLastname($faker->lastName);
        $userAdmin->setUsername($faker->firstName);
        $userAdmin->setRoles(['ROLE_ADMIN']);

        $manager->persist($userAdmin);
        $manager->flush();

        $userUser = new User();
        $userUser->setEmail('user@ex.com');
        $userUser->setPassword($this->encoder->encodePassword($userUser, 'user'));
        $userUser->setFirstname($faker->firstName);
        $userUser->setLastname($faker->lastName);
        $userUser->setUsername($faker->firstName);

        $manager->persist($userUser);
        $manager->flush();

        for ($i = 0; $i < 5; $i++) {
        $user = new User();
        $user 
            ->setEmail($faker->email)
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
                    ->setAuthor($faker->firstName)
                    ->setContent($faker->text($maxNbChars = 255))
                    ->setSummary($faker->sentence(6, true))
                    ->setImage($faker->imageUrl($width = 640, $height = 480))
                    ->setCategory($faker->word)
                    ->setCreatedAt($faker->dateTime($max = 'now', $timezone = null));

            $manager->persist($article);
            $manager->flush();
        }
    }
}
