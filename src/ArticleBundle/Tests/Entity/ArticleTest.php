<?php

namespace App\ArticleBundle\Tests\Entity;

use App\ArticleBundle\Entity\Article;
use PHPUnit\Framework\TestCase;

class ArticleTest extends TestCase
{
    public function testTitleSanitize()
    {
        $article = new Article();
        $article->setTitle('foo <a>bar</a>');
        $this->assertEquals('foo bar',$article->getTitle());
    }

    public function testDescriptionSanitizeImage()
    {
        $article = new Article();
        $article->setDescription('foo <img src="">bar</img>');
        $this->assertEquals('foo <img src="">bar</img>',$article->getDescription());
    }

    public function testDescriptionSanitizeLink()
    {
        $article = new Article();
        $article->setDescription('foo <a>bar</a>');
        $this->assertEquals('foo <a>bar</a>',$article->getDescription());
    }

    public function testDescriptionSanitizeHeading()
    {
        $article = new Article();
        $article->setDescription('foo <h1>bar</h1>');
        $this->assertEquals('foo bar',$article->getDescription());
    }

    public function testDescriptionSanitizeScript()
    {
        $article = new Article();
        $article->setDescription('foo <script>alert("bar");</script>');
        $this->assertEquals('foo alert("bar");',$article->getDescription());
    }

    public function testPostedAtPopulation()
    {
        $article = new Article();
        $this->assertNotNull($article->getPostedAt());
    }
}