<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table()
 */
class Customer
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
    private $eMail;
    
    /**
     * @ORM\Column(type="string")
     */
    private $password;
 
    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getEMail() {
        return $this->eMail;
    }

    function getPassword() {
        return $this->password;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setEMail($eMail) {
        $this->eMail = $eMail;
    }

    function setPassword($password) {
        $this->password = $password;
    }


    
}
