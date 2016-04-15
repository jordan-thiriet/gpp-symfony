<?php

namespace TestBundle\Manager;

use CorsBundle\Manager\BaseManager;
use TestBundle\Entity\Project;
use TestBundle\Form\ProjectType;

/**
 *
 * @copyright   2016
 * @author      jthiriet <thirietjordan@gmail.com>
 * Class UserManager
 * @package ProjectBundle\Manager
 */
class ProjectManager extends BaseManager
{
    public function getClass() {
        return new Project();
    }

    public function getType() {
        return ProjectType::class;
    }
}