<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i = 1; $i <= 10; $i++)
        {
            $article = new Article();
            $article->setTitle("Titre de l'article n°$i")
                    ->setContent("<p>Contenu de l'article n°$i</p><br/><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Asperiores dicta enim esse ex possimus similique sint tempore, veritatis! Impedit labore necessitatibus, odio officia optio quia veniam. Aliquid consequatur dolor eveniet explicabo illo maiores qui repudiandae sunt suscipit. Adipisci atque esse explicabo iste laborum necessitatibus nesciunt nostrum! Ad ut vel voluptas!</p>")
                    ->setImage("https://picsum.photos/320/180")
                    ->setDate(new \DateTime());
            $manager->persist($article);
        }

        $manager->flush();
    }
}
