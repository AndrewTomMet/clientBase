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

    private $userName = 'testadmin';
    private $userPass = 'testpass';

    /**
     * @return string
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @return string
     */
    public function getUserPass()
    {
        return $this->userPass;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->removeUser($manager);

        $userAdmin = new User();
        $userAdmin->setUsername($this->userName);
        $userAdmin->setPlainPassword($this->userPass);
        $userAdmin->setEmail('test@email.ua');
        $userAdmin->setSuperAdmin(true);
        $userAdmin->setEnabled(true);

        $manager->persist($userAdmin);
        $manager->flush();
    }

    /**
     * @param ObjectManager $manager
     */
    public function removeUser(ObjectManager $manager)
    {
        $user = $manager->getRepository('ClientBundle:User')->findOneBy(['username' => $this->userName]);
        if (!empty($user)) {
            $manager->remove($user);
            $manager->flush();
        }
    }
}
