<?php

namespace UserBundle\Manager;

use CorsBundle\Manager\BaseManager;
use UserBundle\Entity\User;
use UserBundle\Form\UserType;

/**
 * Manager pour gérer les utilisateurs
 *
 * @copyright   2016
 * @author      jthiriet <thirietjordan@gmail.com>
 * Class UserManager
 * @package UserBundle\Manager
 */
class UserManager extends BaseManager
{

    public function getClass() {
        return new User();
    }

    public function getType() {
        return UserType::class;
    }
}