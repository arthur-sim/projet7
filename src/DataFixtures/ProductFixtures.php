<?php
namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
 
class ProductFixtures extends Fixture 
{
    public function load(ObjectManager $manager)
    {     
        foreach ($this->getproductData() as [ $brand, $name, $year]) {
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
                ['Samsung','GalaxyS10', '2019'],
                ['Samsung','GalaxyS9', '2018'],
                ['Samsung','GalaxyS8', '2017'],
                ['Samsung','GalaxyS7', '2016'],
                ['Samsung','GalaxyS6', '2015']
            ];
    }

}

