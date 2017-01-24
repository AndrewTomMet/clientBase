<?php

namespace ClientBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ClientBundle\Entity\ContactType;

/**
 * Class LoadContactType
 */
class LoadContactType implements FixtureInterface
{
    /**
     * @var string
     */
    private $contactTypeName = 'testContactTypeName';

    /**
     * @return string
     */
    public function getContactTypeName()
    {
        return $this->contactTypeName;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $contactType = new ContactType();
        $contactType->setName($this->contactTypeName);
        $manager->persist($contactType);
        $manager->flush();
    }

    /**
     * @param ObjectManager $manager
     */
    public function removeContactType(ObjectManager $manager)
    {
        $contactType = $manager->getRepository('ClientBundle:ContactType')->findOneBy(['name' => $this->contactTypeName]);
        if (!empty($contactType)) {
            $manager->remove($contactType);
            $manager->flush();
        }
    }
}
