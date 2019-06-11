<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User {

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"user.lite"})
     * @Groups({"user"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user.lite"})
     * @Groups({"user"})
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user.lite"})
     * @Groups({"user"})
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user"})
     */
    private $adress;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user"})
     */
    private $postalCode;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user"})
     */
    private $state;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user"})
     */
    private $city;

    /**
     * @ORM\ManyToOne(targetEntity="Customer")
     * @ORM\JoinColumn(nullable=false)
     */
    private $customer;

    public function getId(): ?int {
        return $this->id;
    }

    function getLastName() {
        return $this->lastName;
    }

    function getFirstName() {
        return $this->firstName;
    }

    function setLastName($lastName) {
        $this->lastName = $lastName;
    }

    function setFirstName($firstName) {
        $this->firstName = $firstName;
    }

        
    public function getAdress(): ?string {
        return $this->adress;
    }

    public function setAdress(string $adress): self {
        $this->adress = $adress;

        return $this;
    }

    public function getPostalCode(): ?string {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): self {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getState(): ?string {
        return $this->state;
    }

    public function setState(string $state): self {
        $this->state = $state;

        return $this;
    }

    public function getCity(): ?string {
        return $this->city;
    }

    public function setCity(string $city): self {
        $this->city = $city;

        return $this;
    }

    public function getCustomer() {
        return $this->customer;
    }

    public function setCustomer($customer) {
        $this->customer = $customer;
        return $this;
    }

}
