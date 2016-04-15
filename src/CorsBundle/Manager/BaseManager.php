<?php

namespace CorsBundle\Manager;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 *
 * @copyright   2016
 * @author      jthiriet <thirietjordan@gmail.com>
 * Class BaseManager
 * @package CorsBundle\Manager
 */
abstract class BaseManager
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $container;
    /**
     * @var Object User
     */
    protected $user;

    /**
     * @var boolean isAdmin
     */
    protected $isAdmin;

    /**
     * @var string $repo
     */
    protected $repo;

    /**
     * @var object $responseManager
     */
    protected $responseManager;

    /**
     * @var $request
     */
    protected $request;

    /**
     * @var array $query
     */
    protected $query;

    /**
     * @var array $query
     */
    protected $orderBy;

    /**
     * @var integer $limit
     */
    protected $limit;

    /**
     * @var integer $page
     */
    protected $page;


    /**
     * Manager constructor
     * @param EntityManager $em
     * @param Container $container
     */
    public function __construct(EntityManager $em, Container $container,RequestStack $request, $repo)
    {
        $this->request = $request->getCurrentRequest();
        $this->em = $em;
        $this->container = $container;
        $this->user = $this->container->get('security.token_storage')->getToken() === null ?:$this->container->get('security.token_storage')->getToken()->getUser();
        $this->isAdmin = $this->container->get('security.token_storage')->getToken() === null ?: $this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN');
        $this->responseManager = $this->container->get('cors.response.manager');
        $this->repo = $repo;

        // Get query
        $query = json_decode($this->request->get('query'), true);
        $this->query = $query ?: array();

        // Get order by
        $this->orderBy = json_decode($this->request->get('orderby'), true);

        // Paginate
        $this->limit = json_decode($this->request->get('limit'), true);
        $page = json_decode($this->request->get('page'), true);
        $this->page = $this->limit && $page ? $page * $this->limit : null;

    }

    /**
     * Save entity
     * @param $entity
     */
    public function save($entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
    }

    /**
     * Merge entity
     * @param $entity
     */
    public function update($entity) {
        $this->em->merge($entity);
        $this->em->flush();
    }

    /**
     * Delete entity
     *
     * @param $entity
     */
    public function removeAndFlush($entity)
    {
        $this->em->remove($entity);
        $this->em->flush();
    }

    /**
     * @param $entity
     */
    public function persist($entity) {
        $this->em->persist($entity);
    }

    /**
     * @param $entity
     */
    public function remove($entity) {
        $this->em->remove($entity);
    }


    /**
     *
     */
    public function flush() {
        $this->em->flush();
    }

    /**
     * Return an object
     *
     * @param $id
     * @return mixed
     */
    public function findOr404($id = '')
    {
        $query = array_merge(array("id"=>$id),$this->query);
        $object = $this->getRepository()->findOneBy($query);
        if ($object === null)
            return false;
        return $object;
    }

    /**
     * Return all objects
     *
     * @param $id
     * @return mixed
     */
    public function findAll()
    {
        $object = $this->getRepository()->findBy($this->query, $this->orderBy, $this->limit, $this->page);
        return $object;
    }

    /**
     * Retrun repo
     *
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getRepository()
    {
        return $this->em->getRepository($this->repo);
    }
}
