<?php 

namespace Tests\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\DataFixtures\ProductFixtures;
use App\DataFixtures\UserFixtures;
use App\DataFixtures\CustomerFixtures;
use Liip\TestFixturesBundle\Test\FixturesTrait;

class ProductControllerTest extends WebTestCase
{    
//    
//    use FixturesTrait;
//    
//    private $authenticatedClient;
//    
//    public function setUp()
//    {
//        $this->loadFixtures([
//            ProductFixtures::class,
//            UserFixtures::class
//        ]);
//        
//        $client=static::createClient();
//        $client->request('GET','/token',[],[],[
//            'PHP_AUTH_USER' => 'test1@test.com',
//            'PHP_AUTH_PW'   => 'password',
//        ]);
//        $data = json_decode($client->getResponse()->getContent(), true);
//        $this->authenticatedClient = static::createClient();
//        $this->authenticatedClient->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));
//    }
//    
//    public function testListEmpty()
//    {
//        $this->loadFixtures([]);
//        $this->authenticatedClient->request('GET', '/product');
//        $data = json_decode($this->authenticatedClient->getResponse()->getContent());
//        var_dump($data);
//
//    }
//    
//    public function testListAction()
//    {
//        $client = $this->authenticatedClient;
//        $crawler = $client->request('GET', '/product');
//
//        $this->assertEquals(200, $client->getResponse()->getStatusCode());
//        $data = json_decode($this->authenticatedClient->getResponse()->getContent());
//        var_dump($data);
//    }
//    
//    public function testShowAction(){
//        $client = static::createClient();
//
//        $crawler = $client->request('GET', '/product/1');
//
//        $this->assertEquals(200, $client->getResponse()->getStatusCode());
//        $this->assertContains('','Samsung1');
//    }
//}
    
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
//            ProductFixtures::class,
//            UserFixtures::class
//        ]);
        $this->secondClient = static::createClient();
    }
    
    public function testGetProductWithoutToken()
    {
        $this->secondClient->request('GET', '/product');
        $this->assertSame(401, $this->secondClient->getResponse()->getStatusCode());
    }
    
    public function testGetProductWithToken()
    {
        $client = $this->createAuthenticatedClient();
        $client->request('GET', '/product');
        $this->assertSame(200, $client->getResponse()->getStatusCode());
    } 
    
    public function testGetOneProductWithToken()
    {
        $client = $this->createAuthenticatedClient();
        $client->request('GET', '/product/8');
        
        $this->assertSame(200, $client->getResponse()->getStatusCode());  
        $body = json_decode($client->getResponse()->getContent(), true);
        $this->assertSame('GalaxyS8', $body['name']);   
        
        
    }
    
    public function testGetOneProductWithoutToken()
    {
        $this->secondClient->request('GET', '/product/1');
        $this->assertSame(401, $this->secondClient->getResponse()->getStatusCode());
    }
}