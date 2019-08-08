<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TokenControllerTest extends WebTestCase{
    
    public function testRightAuthenticationToken(){
        $client=static::createClient();
        $client->request('GET','/token',[],[],[
            'PHP_AUTH_USER' => 'test1@test.com',
            'PHP_AUTH_PW'   => 'password',
        ]);
        $this->assertEquals(200,$client->getResponse()->getStatusCode());
    }
    
    public function testWrongAuthenticationToken(){
        $client=static::createClient();
        $client->request('GET','/token',[],[],[
            'PHP_AUTH_USER' => 'test1@test.com',
            'PHP_AUTH_PW'   => 'wrongpassword',
        ]);
        $this->assertEquals(403,$client->getResponse()->getStatusCode());
    }
    
    public function testNoAuthenticationToken(){
        $client=static::createClient();
        $client->request('GET','/token');
        $this->assertEquals(401,$client->getResponse()->getStatusCode());
    }
    
}
