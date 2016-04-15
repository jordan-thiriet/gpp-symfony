<?php

namespace CorsBundle\Entity;

use FOS\OAuthServerBundle\Entity\Client as BaseClient;
use Doctrine\ORM\Mapping as ORM;

/**
 * Definition de l'entité qui stock les clients de l'api
 *
 * @copyright   2014 Thiriet Jordan
 * @author      jthiriet <thirietjordan@gmail.com>
 * Class Client
 * @package CorsBundle\Entity
 *
 * @ORM\Entity
 */
class Client extends BaseClient
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}