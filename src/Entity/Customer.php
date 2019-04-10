<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @ORM\Table()
 */
class Customer implements UserInterface
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
 
    function getId(): ?int {
        return $this->id;
    }

    function getName(): ?string {
        return $this->name;
    }

    function getEMail(): ?string {
        return $this->eMail;
    }

    function getPassword(): ?string {
        return $this->password;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setName(string $name): self {
        $this->name = $name;
        
        return $this;
    }

    function setEMail(string $eMail): self{
        $this->eMail = $eMail;
        
        return $this;
        
    }

    function setPassword(string $password): self {
        $this->password = $password;
        
        return $this;
    }

    public function eraseCredentials() {
        
    }

    public function getRoles() {
        return ['ROLE_USER'];
    }

    public function getSalt() {
        return null;
    }

    public function getUsername(): string {
        return $this->getEMail();
    }

}
