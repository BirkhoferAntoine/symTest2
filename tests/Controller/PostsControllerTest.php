<?php

namespace App\Tests\Controller;

use App\Controller\PostsController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class PostsControllerTest extends WebTestCase
{

    public function init(): int
    {
        $client = static::createClient();
        $rdmNumber = random_int(1,10);
        $client->request('GET', "/posts/$rdmNumber");
        return $rdmNumber;
    }

    public function testShow(): void
    {
        $this->init();
        self::assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testH1Show(): void
    {
        $n = $this->init();
        self::assertSelectorTextContains('h2', "Titre de l'article n°$n");
    }

    public function testHasFixedContent(): void
    {
        $this->init();
        self::assertSelectorExists('article', 'Found article' );
    }

}