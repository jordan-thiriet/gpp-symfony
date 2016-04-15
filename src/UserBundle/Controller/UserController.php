<?php

namespace UserBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Get;

class UserController extends FOSRestController
{

    /**
     * @Get("/user/{id}", name="_getUser")
     */
    public function getUserAction($id)
    {
        $object = array();
        $view = $this->view($object, 200);
        return $this->handleView($view);
    }
}
