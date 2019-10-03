<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Hateoas\Configuration\Annotation as Hateoas;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;
use App\Service\SerializeFormError;
use App\Exception\FormErrorException;

/**
 * @Hateoas\Relation(
 *  "index",
 *      href = @Hateoas\Route(
 *          "user_index",
 *      ),
 *      exclusion = @Hateoas\Exclusion(
 *          excludeIf = "expr(not is_granted(['ROLE_ADMIN']))"
 *      )
 * )
 * @Hateoas\Relation(
 *  "showById",
 *      href = @Hateoas\Route(
 *          "user_show",
 *          parameters = { "id" = "expr(object.getId())" }
 *      ),
 *      exclusion = @Hateoas\Exclusion(
 *          excludeIf = "expr(not is_granted(['ROLE_ADMIN']))"
 *      )
 * )
 * @Hateoas\Relation(
 * "delete",
 *      href = @Hateoas\Route(
 *          "user_delete",
 *          parameters = { "id" = "expr(object.getId())" }
 *      ),
 *      exclusion = @Hateoas\Exclusion(
 *          excludeIf = "expr(not is_granted(['ROLE_ADMIN']))"
 *      )
 * )
 * @Hateoas\Relation(
 * "create",
 *      href = @Hateoas\Route(
 *          "user_create",
 *          parameters = { "adress" = "expr(object.getAdress())",
 *                         "postalCode" = "expr(object.getPostalCode())" ,
 *                         "state" = "expr(object.getState())",
 *                         "city" = "expr(object.getCity())"
 *                       }
 *      ),
 *      exclusion = @Hateoas\Exclusion(
 *          excludeIf = "expr(not is_granted(['ROLE_ADMIN']))"
 *      )
 * )
 * @Hateoas\Relation(
 * "update",
 *      href = @Hateoas\Route(
 *          "user_modify",
 *          parameters = { "id" = "expr(object.getId())" }
 *      ),
 *      exclusion = @Hateoas\Exclusion(
 *          excludeIf = "expr(not is_granted(['ROLE_ADMIN']))"
 *      )
 * )
 */
class UserController extends AbstractApiController {

    /**
     * List User by group : user.lite
     * 
     * @SWG\Response(
     *     description="Returns users",
     *     response=200,
     *     @Model(type=User::class, groups={"user.lite"})
     * )
     * @Route("/user", name="user_index", methods={ "GET" })
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $userRepository = $em->getRepository(User::class);

        $users = $userRepository->findAll();

        return $this->json($users, 200, [], ['groups' => ['user']]);
    }

    /**
     * List a User by id
     * 
     * @SWG\Response(
     *     description="Returns a user ",
     *     response=200,
     *     @Model(type=User::class, groups={"user"})
     * )
     * @Route("/user/{id}", name="user_show", methods={ "GET" })
     */
    public function showAction(User $user)
    {
        return $this->json($user, 200, [], ['groups' => ['user.lite']]);
    }

    /**
     * Delete user
     * 
     * @SWG\Response(
     *     description="delete a user",
     *     response=200,
     *     @Model(type=User::class,groups={"user"})
     * )
     * @Route("/user/{id}", name="user_delete", methods={ "DELETE" })
     */
    public function deleteAction(User $user) {
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        return $this->json(['message' => 'success']);
    }

    /**
     * New User
     * @SWG\Parameter(
     *  name="create user", 
     *  in="body",
     *  @Model(type=UserType::class)
     * )
     * @SWG\Response(
     *     description="create user",
     *     response=200,
     *     @Model(type=User::class,groups={"user"})
     * )
     * @Route("/user/", name="user_create", methods={ "POST" })
     *
     * @example body: {"name":"Honor 9", "memory":"32Gb"}
     */
    public function createAction(Request $request) {
        $user = new User();
        $userForm = $this->createForm(UserType::class, $user);
        $user->setCustomer($this->getUser());
        $userForm->submit($request->request->all());
        if ($userForm->isSubmitted() && $userForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->json(['message' => 'success'], 201);
        }
        throw new FormErrorException($userForm);
//        return $this->json(['errors' => $this->serializeErrors($userForm) ], 400);
        
        
    }

    
    
    /**
     * User edition
     * @SWG\Parameter(
     *  name="modify user", 
     *  in="body",
     *  @Model(type=UserType::class)
     * )
     * @SWG\Response(
     *     description="edit a user",
     *     response=200,
     *     @Model(type=User::class, groups={"user"})
     * )
     * @Route("/user/{id}", name="user_modify", methods={ "PUT" })
     *
     * @example body: {"name":"Honor 9", "memory":"32Gb"}
     */
    public function modifyAction(Request $request, User $user, SerializeFormError $serialize) {

        $userForm = $this->createForm(UserType::class, $user);
                var_dump(json_decode($request->getContent()));
        $userForm->submit(json_decode($request->getContent()));

        if ($userForm->isSubmitted() && $userForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->json(['message' => 'success'], 200);
        }

        return $this->json($serialize->serializeErrors($userForm), 400);
    }

}
