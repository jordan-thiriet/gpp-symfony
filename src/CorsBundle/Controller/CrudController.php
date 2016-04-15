<?php

namespace CorsBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Delete;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Util\Codes;

class CrudController extends FOSRestController
{

    /**
     * @Get("/{type}s", name="_getAll")
     */
    public function getAllAction($type)
    {
        $objectManager = $this->get($type.'.manager');
        $objects = $objectManager->findAll();
        return $this->view($objects, Codes::HTTP_OK);

    }

    /**
     * @Get("/{type}/{id}", name="_get")
     */
    public function getAction($type, $id)
    {
        $objectManager = $this->get($type.'.manager');
        $object = $objectManager->findOr404($id);
        if($object === false) {
            return $this->view(null, Codes::HTTP_NOT_FOUND);
        }
        return $this->view($object, Codes::HTTP_OK);
    }

    /**
     * @Post("/{type}", name="_post")
     */
    public function postAction(Request $request, $type)
    {
        $objectManager = $this->get($type.'.manager');
        $object = $objectManager->getClass();
        $form = $this->createForm($objectManager->getType(), $object);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $objectManager->save($object);
            return $this->view($object, Codes::HTTP_CREATED);
        }

        return $this->view(null, Codes::HTTP_NOT_MODIFIED);
    }

    /**
     * @Put("/{type}/{id}", name="_put")
     */
    public function putAction(Request $request, $type, $id)
    {
        $objectManager = $this->get($type.'.manager');
        $object = $objectManager->findOr404($id);

        if($object === false) {
            return $this->view(null, Codes::HTTP_NOT_FOUND);
        }

        $form = $this->createForm($objectManager->getType(), $object, array('method' => 'PUT'));

        $form->handleRequest($request);

        if ($form->isValid()) {
            $objectManager->save($object);
            return $this->view(null, Codes::HTTP_NO_CONTENT);
        }

        return $this->view(null, Codes::HTTP_NOT_MODIFIED);
    }

    /**
     * @Delete("/{type}/{id}", name="_delete")
     */
    public function deleteAction($type, $id)
    {
        $objectManager = $this->get($type.'.manager');
        $object = $objectManager->findOr404($id);
        if($object === false) {
            return $this->view(null, Codes::HTTP_NOT_FOUND);
        }
        $objectManager->removeAndFlush($object);
        return $this->view(null, Codes::HTTP_OK);
    }

}
