<?php


namespace App\DataFixtures;


use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserFixtures extends Fixture
{

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
    for ($i = 0; $i < 10; $i++) {
        $user = new User();
        $user->setUsername("user$i")
            ->setEmail("user$i@example.com")
            ->setPassword('password')
            ->setRoles(['ROLE_USER' => 'true']);

        $manager->persist($user);
    }

        $manager->flush();
    }
}