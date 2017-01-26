<?php

namespace ClientBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ClientBundle\Entity\User;

/**
 * Class LoadUserData
 */
class LoadUserData implements FixtureInterface
{

    const TESTUSERNAME = 'sysadmin';
    const TESTUSERPASS = 'sysadmin';

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $userAdmin = new User();
        $userAdmin->setUsername($this::TESTUSERNAME);
        $userAdmin->setPlainPassword($this::TESTUSERPASS);
        $userAdmin->setEmail('test@email.ua');
        $userAdmin->setSuperAdmin(true);
        $userAdmin->setEnabled(true);

        $manager->persist($userAdmin);
        $manager->flush();
    }
}
