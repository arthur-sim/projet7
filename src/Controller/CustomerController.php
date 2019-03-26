<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Form\CustomerType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;

class CustomerController extends AbstractController
{
    /**
     * List Customer by group : customer.lite
     * 
     * @SWG\Response(
     *     description="Returns customers",
     *     response=200,
     *     @Model(type=Customer::class, groups={"customer.lite"})
     * )
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
     * List a customer by id
     * 
     * @SWG\Response(
     *     description="Returns a customer ",
     *     response=200,
     *     @Model(type=Customer::class)
     * )
     * @Route("/customer/{id}", name="customer_show", methods={ "GET" })
     */
    public function showAction(Customer $customer)
    {
        return $this->json($customer);
    }

    
}