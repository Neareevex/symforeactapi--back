<?php

namespace App\DataFixtures;

use App\Entity\Publication;
use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class InitFixtures extends Fixture
{  private $encoder;
    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }
   public function load(ObjectManager $manager) {
    $faker = Factory::create('fr_FR');

    $user = new User();
    $hash = $this->encoder->hashPassword($user, 'aleth');
    $user->setEmail('aleth@aleth.fr')
            ->setIsAuthor(false)
            ->setPassword($hash);
    $manager->persist($user);

    for ($i=0; $i < 2; $i++) {
        $user->setEmail('aleth@aleth.fr')
        ->setIsAuthor(false)
        ->setPassword($hash);
        $manager->persist($user);
        for ($p=0; $p < 3; $p++) {
            $publication = new Publication();
            $publication->setContent('lorem ipsum')
                ->setTitle('Titre ici')
                ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                ->setWrittenBy($user);
                $manager->persist($publication);
        }
    }
    $manager->flush();
}
}
