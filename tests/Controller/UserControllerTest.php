<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\DataFixtures\UserFixtures;
use App\DataFixtures\CustomerFixtures;
use Liip\TestFixturesBundle\Test\FixturesTrait;

class UserControllerTest extends WebTestCase
{    
    use FixturesTrait;
    
    public function setUp()
    {
        $this->loadFixtures([
            UserFixtures::class,
            CustomerFixtures::class
        ]);
    }

    public function testListEmpty()
    {
        $this->loadFixtures([]);

        $client = static::createClient();
        $crawler = $client->request('GET', '/user');

        $this->assertSelectorTextNotContains('admin1');
    }
    
    public function testListAction()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/user');

        $this->assertSelectorTextContains('admin1');
    }
    
    public function testCreateAction(){
        $client = static::createClient();
        $client->request('GET','/token',[],[],[
            'PHP_AUTH_USER' => 'test1@test.com',
            'PHP_AUTH_PW'   => 'password'
        ]);
         
        $crawler = $client->request('GET', '/user/create');
        
        $client->xmlHttpRequest('POST', '/submit',  ['username' => 'testUsername',
                                                     'password' => 'testPassword',
                                                     'email' => 'test@email.com',
                                                     'roles' => 'ROLE_USER']);
        
        $client->followRedirect();

        $this->assertSelectorTextContains('testUsername');
    }
    
    public function testEditAction(){
        $client = static::createClient();
        $client->request('GET','/token',[],[],[
            'PHP_AUTH_USER' => 'test1@test.com',
            'PHP_AUTH_PW'   => 'password'
        ]);
        
        $crawler = $client->request('GET', '/user/1/edit');     
        
        $client->xmlHttpRequest('UPDATE', '/submit',  ['username' => 'testUsername']);
        
        $client->followRedirect();

        $this->assertSelectorTextContains('testEditUsername');
    }
}
