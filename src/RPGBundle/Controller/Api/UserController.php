<?php

namespace RPGBundle\Controller\Api;

use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use RPGBundle\Exception\UserException;
use RPGBundle\Model\Error;
use RPGBundle\Model\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\FOSRestController;

/**
 * @Route("/api")
 */
class UserController extends FOSRestController
{
    /**
     * @Post("/user")
     * @QueryParam(name="name", requirements="\w+", description="User nickname")
     * @QueryParam(name="role", requirements="\d+", description="User role")
     * @QueryParam(name="password", requirements="\d+", description="User password")
     *
     * @ApiDoc(
     *     section="User",
     *     description="User related api"
     * )
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        try {
            $name = $request->get("name");
            $role = $request->get("role");
            $password = $request->get("password");
            $user = $this->get("rpg.user")->createUser($name, $role, $password);
            $response = new Response($user);

            return $response;
        } catch (UserException $e) {
            $error = new Error($e->getMessage());
            $response = new Response(null, false, $error);

            return $response;
        } catch (\Exception $e) {
            $error = new Error();
            $response = new Response(null, false, $error, 500);

            return $response;
        }
    }

    /**
     * @Get("/secure/user/{user}", requirements={"user" = "\d+"})
     * @QueryParam(name="apikey",  description="Api key")
     *
     * @ApiDoc(
     *     section="User",
     *     description="User related api"
     * )
     * @param Request $request
     * @param $user
     * @return Response
     */
    public function getUserData(Request $request, $user)
    {
        try {
            $userData = $this->get("rpg.user")->get($user);
            $response = new Response($userData);

            return $response;
        } catch (UserException $e) {
            $error = new Error($e->getMessage());
            $response = new Response(null, false, $error);

            return $response;
        } catch (\Exception $e) {
            $error = new Error();
            $response = new Response(null, false, $error, 500);

            return $response;
        }
    }

    /**
     * @Get("/roles")
     *
     * @ApiDoc(
     *     section="User",
     *     description="Roles of user"
     * )
     * @param Request $request
     * @return Response
     */
    public function getRoles(Request $request)
    {
        try {
            $roles = $this->get("rpg.user")->getRoles();
            $response = new Response($roles);

            return $response;
        } catch (UserException $e) {
            $error = new Error($e->getMessage());
            $response = new Response(null, false, $error);

            return $response;
        } catch (\Exception $e) {
            $error = new Error();
            $response = new Response(null, false, $error, 500);

            return $response;
        }
    }

    /**
     * @Post("/user/auth")
     * @QueryParam(name="nickname", requirements="\w+", description="User nickname")
     * @QueryParam(name="password", requirements="\d+", description="User password")
     *
     * @ApiDoc(
     *     section="User",
     *     description="User related api"
     * )
     * @param Request $request
     * @return Response
     */
    public function auth(Request $request)
    {
        try {
            $nickname = $request->get("nickname");
            $password = $request->get("password");
            $user = $this->get("rpg.user")->getUserByPassword($nickname, $password);
            if (!$user) {
                throw new UserException("User is not found!");
            }

            $response = new Response($user);

            return $response;
        } catch (UserException $e) {
            $error = new Error($e->getMessage());
            $response = new Response(null, false, $error);

            return $response;
        } catch (\Exception $e) {
            $error = new Error();
            $response = new Response(null, false, $error, 500);

            return $response;
        }
    }
}