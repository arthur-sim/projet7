<?php
namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
 
class ProductFixtures extends Fixture 
{
    public function load(ObjectManager $manager)
    {     
        foreach ($this->getProductData() as [ $brand, $name, $year]) {
            $product = (new Product())
                    ->setBrand($brand)
                    ->setName($name)
                    ->setYear($year);                   
            $manager->persist($product);    
        }
 
        $manager->flush();
    }
 
    private function getProductData(): array
    {
        return [
                ['Samsung1','GalaxyS10', '2019'],
                ['Samsung2','GalaxyS9', '2018'],
                ['Samsung3','GalaxyS8', '2017'],
                ['Samsung4','GalaxyS7', '2016'],
                ['Samsung5','GalaxyS6', '2015']
            ];
    }

}

