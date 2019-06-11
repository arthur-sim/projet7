<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Form\CustomerType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CustomerController extends AbstractController
{
    /**
     * @Route("/customer", name="customer_index", methods={ "GET" })
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $customerRepository = $em->getRepository(Customer::class);

        $customers = $customerRepository->findAll();

        return $this->json($customers, 200, [], ['groups' => ['customer.lite']]);
    }

    /**
     * @Route("/customer/{id}", name="customer_show", methods={ "GET" })
     */
    public function showAction(Customer $customer)
    {
        return $this->json($customer);
    }

    
}