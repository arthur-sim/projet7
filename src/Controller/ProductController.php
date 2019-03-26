<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;

class ProductController extends AbstractController {

    /**
     * List Product by group : product.lite
     * 
     * @SWG\Response(
     *     description="Returns products",
     *     response=200,
     *     @Model(type=Product::class, groups={"product.lite"})
     * )
     * @Route("/product", name="product_index", methods={ "GET" })
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $productRepository = $em->getRepository(Product::class);

        $products = $productRepository->findAll();

        return $this->json($products, 200, [], ['groups' => ['product.lite']]);
    }

    /**
     * List a Product by id
     * 
     * @SWG\Response(
     *     description="Returns a product ",
     *     response=200,
     *     @Model(type=Product::class)
     * )
     * @Route("/product/{id}", name="product_show", methods={ "GET" })
     */
    public function showAction(Product $product) {
        return $this->json($product);
    }

}
