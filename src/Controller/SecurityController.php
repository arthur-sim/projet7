<?php

namespace App\Controller;

use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    /**
     * @Route("/token", name="security_token")
     * @throws Exception
     */
    public function tokenAction()
    {
        throw  new Exception("Shouldn't be reached");
    }
}
