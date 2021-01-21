<?php


namespace App\Tests\Repository;


use App\DataFixtures\UserFixtures;
use App\Repository\UserRepository;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validation;

class UserRepositoryTest extends KernelTestCase
{

    use FixturesTrait;
    private $usersFix;

    public function testCount(): void
    {
        self::bootKernel();
        $this->usersFix = $this->loadFixtureFiles([
            __DIR__ . '/UserRepositoryTestFixtures.yaml'
        ]);
        $users = self::$container->get(UserRepository::class)->count([]);
        self::assertEquals(10, $users);
    }

}

// $this->loadFixtures([UserFixtures::class]);