<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table()
 */
class User
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;
    
    /**
     * @ORM\Column(type="string")
     */
    private $adress;
    
    /**
     * @ORM\Column(type="string")
     */
    private $city;
    
    /**
     * @ORM\ManyToOne(targetEntity="customer")
     * @ORM\JoinColumn(nullable=false)
     */
    private $customer;

        
    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getAdress() {
        return $this->adress;
    }

    function getCity() {
        return $this->city;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setAdress($adress) {
        $this->adress = $adress;
    }

    function setCity($city) {
        $this->city = $city;
    }



}
