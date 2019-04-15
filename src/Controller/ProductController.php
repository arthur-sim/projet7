<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @Hateoas\Relation(
 *  "index",
 *      href = @Hateoas\Route(
 *          "product_index",
 *      ),
 *      exclusion = @Hateoas\Exclusion(
 *          excludeIf = "expr(not is_granted(['ROLE_ADMIN']))"
 *      )
 * )
 * @Hateoas\Relation(
 *  "showById",
 *      href = @Hateoas\Route(
 *          "product_show",
 *          parameters = { "id" = "expr(object.getId())" }
 *      ),
 *      exclusion = @Hateoas\Exclusion(
 *          excludeIf = "expr(not is_granted(['ROLE_ADMIN']))"
 *      )
 * )
 */
class ProductController extends AbstractController {

    /**
     * @Route("/product", name="product_index", methods={ "GET" })
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $productRepository = $em->getRepository(Product::class);

        $products = $productRepository->findAll();

        return $this->json($products, 200, [], ['groups' => ['product.lite']]);
    }

    /**
     * @Route("/product/{id}", name="product_show", methods={ "GET" })
     */
    public function showAction(Product $product) {
        return $this->json($product);
    }

}
