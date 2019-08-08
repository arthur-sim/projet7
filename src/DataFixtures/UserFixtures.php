<?php
namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\DataFixtures\CustomerFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
 
class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {     
        foreach ($this->getUserData() as [$last_name, $first_name,$adress, $postalCode, $state, $city]) {
            $customer = $this->getReference('customer_'.rand(0, CustomerFixtures::$nbCustomers));
            $user = (new User())
                    ->setLastName($last_name)
                    ->setFirstName($first_name)
                    ->setAdress($adress)
                    ->setPostalCode($postalCode)
                    ->setState($state)
                    ->setCity($city)
                    ->setCustomer($customer);                   
            $manager->persist($user);     
        }
 
        $manager->flush();
    }
 
    private function getUserData(): array
    {
        return [
            ['test','test','12 avenue maguy barbaroux', '13400', 'france', 'aubagne'],
            ['test','test','12 rue paradis', '13990', 'france', 'pin vert'], 
            ['test','test','24 avenue maguy barbaroux', '13400', 'france', 'aubagne'], 
            ['test','test','52 impasse chrales comté', '15900', 'france', 'cuges']
        ];
    }
 
    public function getDependencies()
    {
        return array(
            CustomerFixtures::class,
        );
    }
 
}
