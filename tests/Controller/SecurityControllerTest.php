<?php

namespace App\Tests\Controller;

use App\Controller\SecurityController;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\AbstractBrowser;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DomCrawler\Crawler;


class SecurityControllerTest extends WebTestCase
{
    use FixturesTrait;

    private AbstractBrowser $client;

    public function init(): Crawler
    {
        $this->client = static::createClient();
        $this->loadFixtureFiles([__DIR__ . '/../Entity/Users.yaml']);
        return $this->client->request('GET', '/login');
    }

    public function testDisplayLogin(): void
    {
        $this->init();
        self::assertResponseStatusCodeSame(Response::HTTP_OK);
        self::assertSelectorTextContains('h1', 'Se connecter');
        self::assertSelectorNotExists('.alert.alert-danger');
    }

    public function testLoginWithBadCredentials(): void
    {
        $crawler    = $this->init();
        $form       = $crawler->selectButton('Se connecter')->form([
            'username' => 'user1',
            'password' => 'badpassword'
        ]);
        $this->client->submit($form);
        self::assertResponseRedirects('/login');
        $this->client->followRedirect();
        self::assertSelectorExists('.alert.alert-danger');
    }

    public function testSuccessfulLogin()
    {
        $crawler    = $this->init();
        $form       = $crawler->selectButton('Se connecter')->form([
            'username' => 'user1',
            'password' => 'password'
        ]);
        $this->client->submit($form);
        self::assertResponseRedirects('/auth');
    }

    public function testLoginWithPost()
    {
        $client = static::createClient();
        $csrfToken = $client->getContainer()->get('security.csrf.token_manager')->getToken('authenticate');
        $client->request('POST', '/login', [
            '_csrf_token' => $csrfToken,
            'username' => 'user1',
            'password' => 'password'
        ]);
        self::assertResponseRedirects('/auth');
    }

}
