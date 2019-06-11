<?php
namespace App\DataFixtures;

use App\Entity\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
 
class CustomerFixtures extends Fixture
{
    public static $nbCustomers = -1;
    public function load(ObjectManager $manager)
    {
        foreach ($this->getCustomerData() as [ $name, $eMail, $password]) {
            $customer = (new Customer())
                    ->setName($name)
                    ->setEMail($eMail)
                    ->setPassword($password);
            $manager->persist($customer);
            self::$nbCustomers++;
            $this->addReference('customer_'.self::$nbCustomers, $customer);
            
        }
 
        $manager->flush();
    }
 
    private function getCustomerData(): array
    {
        return [
            ['admin1','test1@test.com','password'],
            ['admin2','test2@test.com','password'],
            ['admin3','test3@test.com','password']
        ];
    }
 
 
}