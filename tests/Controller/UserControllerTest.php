<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\DataFixtures\UserFixtures;
use App\DataFixtures\CustomerFixtures;
use Liip\TestFixturesBundle\Test\FixturesTrait;

class UserControllerTest extends WebTestCase
{    
    
    //    public function testListEmpty()
//    {
//        $this->loadFixtures([]);
//
//        $client = static::createClient();
//        $crawler = $client->request('GET', '/user');
//
//        $this->assertSelectorTextNotContains('','admin1');
//    }
//    
//    public function testListAction()
//    {
//        $client = static::createClient();
//        $crawler = $client->request('GET', '/user');
//
//        $this->assertSelectorTextContains('','admin1');
//    }
//    
//    public function testCreateAction(){
//        $client = static::createClient();
//        $client->request('GET','/token',[],[],[
//            'PHP_AUTH_USER' => 'test1@test.com',
//            'PHP_AUTH_PW'   => 'password'
//        ]);
//         
//        $crawler = $client->request('GET', '/user/create');
//        
//        $client->xmlHttpRequest('POST', '/submit',  ['username' => 'testUsername',
//                                                     'password' => 'testPassword',
//                                                     'email' => 'test@email.com',
//                                                     'roles' => 'ROLE_USER']);
//        
//        $client->followRedirect();
//
//        $this->assertSelectorTextContains('','testUsername');
//    }
//    
//    public function testEditAction(){
//        $client = static::createClient();
//        $client->request('GET','/token',[],[],[
//            'PHP_AUTH_USER' => 'test1@test.com',
//            'PHP_AUTH_PW'   => 'password'
//        ]);
//        
//        $crawler = $client->request('GET', '/user/1/edit');     
//        
//        $client->xmlHttpRequest('UPDATE', '/submit',  ['username' => 'testUsername']);
//        
//        $client->followRedirect();
//
//        $this->assertSelectorTextContains('','testEditUsername');
//    }
    
    use FixturesTrait;
    
    protected function createAuthenticatedClient($username = 'test1@test.com', $password = 'password')
    {
        $client=static::createClient();
        $client->request('GET','/token',[],[],[
            'PHP_AUTH_USER' => $username,
            'PHP_AUTH_PW'   => $password,
        ]);
        
        $data = json_decode($client->getResponse()->getContent(), true);
        $client = static::createClient();
        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data["token"]));
        
        return $client;
    }
    
    public function setUp()
    {
//        $this->loadFixtures([
//            UserFixtures::class
//        ]);
        
        $this->secondClient = static::createClient();
    }

    public function testGetUserWithoutToken()
    {
        $this->secondClient->request('GET', '/user');
        $this->assertSame(401, $this->secondClient->getResponse()->getStatusCode());
    }
    
    public function testGetUserWithToken()
    {
        $client = $this->createAuthenticatedClient();
        $client->request('GET', '/user');
        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }  
   
    public function testGetOneUserWithToken()
    {
        $client = $this->createAuthenticatedClient();
        $client->request('GET', '/user/1');
        $this->assertSame(200, $client->getResponse()->getStatusCode());   
    } 
    
    public function testGetOneUserWithoutToken()
    {
        $this->secondClient->request('GET', '/user/1');
        $this->assertSame(401, $this->secondClient->getResponse()->getStatusCode());  
    }
}
