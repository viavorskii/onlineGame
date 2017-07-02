<?php

namespace RPGBundle\Controller\Api;

use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use RPGBundle\Exception\UserException;
use RPGBundle\Model\Error;
use RPGBundle\Model\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/api")
 */
class ExploreController extends FOSRestController
{
    /**
     * @Post("/secure/step")
     * @QueryParam(name="user", requirements="\d+", description="User id")
     * @QueryParam(name="apikey",  description="Api key")
     *
     * @ApiDoc(
     *     section="Explore",
     *     description="Explore related api"
     * )
     * @param Request $request
     * @return Response
     */
    public function step(Request $request)
    {
        try {
            $user = $request->get("user");
            $content = $this->get("rpg.explore")->step($user);

            $response = new Response($content);

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