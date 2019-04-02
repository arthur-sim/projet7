<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class TokenController extends AbstractController{

    
    /**
     * @Route("/api/tokens")
     * @Method("POST")
     */
    public function newTokenAction(Request $request) {
        $customer = $this->getDoctrine()
                ->getRepository('App:Customer')
                ->findOneBy(['name' => $request->getCustomer()]);
        if (!$customer) {
            throw $this->createNotFoundException();
        }
        $isValid = $this->get('security.password_encoder')
                ->isPasswordValid($customer, $request->getPassword());
        if (!$isValid) {
            throw new BadCredentialsException();
        }
        $token = $this->get('lexik_jwt_authentication.encoder')
                ->encode([
            'name' => $customer->getName(),
            'exp' => time() + 3600 // 1 heure avant expiration
        ]);
        return new JsonResponse(['token' => $token]);
    }
    
}
