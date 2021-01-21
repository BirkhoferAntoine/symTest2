<?php

namespace App\Tests\Controller;

use App\Controller\AuthController;
use App\Entity\User;
use App\Tests\NeedLogin;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use App\Security\AppAuthenticator;

class AuthControllerTest extends WebTestCase
{
    use NeedLogin;

    public function init()
    {
        $client = static::createClient();
        $client->request('GET', '/auth');
    }

    public function testAuthPageIsRestricted(): void
    {
        $this->init();
        self::assertResponseRedirects('/login');
    }

    public function testRedirectToLoginPage(): void
    {
        $this->init();
        self::assertResponseRedirects('/login');
    }

    public function testAuthenticatedHasAuthAccess(): void
    {
        $client = static::createClient();
        //TODO UserProvider
        $client->request('GET', '/auth');
        self::assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}
