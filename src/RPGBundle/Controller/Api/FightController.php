<?php

namespace RPGBundle\Controller\Api;

use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use RPGBundle\Exception\UserException;
use RPGBundle\Model\Error;
use RPGBundle\Model\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\Route;

/**
 * @Route("/api")
 */
class FightController extends FOSRestController
{
    /**
     * @Post("/secure/fight")
     * @QueryParam(name="user", requirements="\d+", description="User id")
     * @QueryParam(name="fight", requirements="\d+", description="Fight id")
     * @QueryParam(name="action", requirements="\w+", description="action")
     * @QueryParam(name="apikey",  description="Api key")
     *
     * @ApiDoc(
     *     section="Fight",
     *     description="Fight related api"
     * )
     * @param Request $request
     * @return Response
     */
    public function step(Request $request)
    {
        try {
            $user = $request->get("user");
            $fight = $request->get("fight");
            $action = $request->get("action");
            $content = $this->get("rpg.explore")->fight($user, $fight, $action);

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