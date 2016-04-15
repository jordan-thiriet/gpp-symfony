<?php

namespace CorsBundle\DataFixtures\Install;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use UserBundle\Entity\User;

class LoadUserData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $userAdmin = new User();
        $userAdmin->setUsername('admin');
        $userAdmin->setPassword('@dm!n');
        $userAdmin->setFirstname('Admin');
        $userAdmin->setLastname('Admin');
        $userAdmin->setEmail('admin@gpp.io');
        $userAdmin->setRoles(array('ROLE_SUPER_ADMIN'));
        $manager->persist($userAdmin);

        $userDemo = new User();
        $userDemo->setUsername('demo');
        $userDemo->setPassword('demo');
        $userDemo->setFirstname('Demo');
        $userDemo->setLastname('Demo');
        $userDemo->setEmail('demo@gpp.io');
        $userDemo->setRoles(array('ROLE_USER'));
        $manager->persist($userDemo);

        $manager->flush();
    }
}