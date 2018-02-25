<?php

namespace App\AdminBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArticleTest extends WebTestCase
{
    private $url_prefix = "/admin/articles/";

    public function testCreateRoute()
    {
        $client = static::createClient();
        $client->request('GET', $this->url_prefix . 'create');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testCreateRouteFormContainTitle()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', $this->url_prefix . 'create');

        $this->assertEquals(
            1,
            $crawler->filter('#article_title')->count()
        );
    }

    public function testCreateRouteFormContainDescription()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', $this->url_prefix . 'create');

        $this->assertEquals(
            1,
            $crawler->filter('#article_description')->count()
        );
    }

    public function testCreateRouteFormContainSubmit()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', $this->url_prefix . 'create');

        $this->assertEquals(
            1,
            $crawler->filter('input[type=submit]')->count()
        );
    }
}