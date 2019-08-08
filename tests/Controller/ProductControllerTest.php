<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\DataFixtures\ProductFixtures;
use Liip\TestFixturesBundle\Test\FixturesTrait;

class ProductControllerTest extends WebTestCase
{    
    
    use FixturesTrait;
    
    public function setUp()
    {
        $this->loadFixtures([
            ProductFixtures::class
        ]);
    }
    
    public function testListEmpty()
    {
        $this->loadFixtures([]);

        $client = static::createClient();
        $crawler = $client->request('GET', '/product');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextNotContains('Samsung1');
    }
    
    public function testListAction()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/product');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertSelectorTextContains('Samsung1');   
    }
    
    public function testShowAction(){
        $client = static::createClient();

        $crawler = $client->request('GET', '/product/1');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Samsung1');
    }
}