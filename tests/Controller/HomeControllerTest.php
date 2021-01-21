<?php

namespace App\Tests\Controller;

use App\Controller\HomeController;
use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class HomeControllerTest extends WebTestCase
{

    public function init(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');
    }

    public function testIndex(): void
    {
        $this->init();
        self::assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testH1Index(): void
    {
        $this->init();
        self::assertSelectorTextContains('h1', 'Bienvenue');
    }

    public function testHasFixedContent(): void
    {
        $this->init();
        self::assertSelectorExists('article', 'Found article' );
    }

}
