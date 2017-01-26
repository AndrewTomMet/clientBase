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
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $contactType = new ContactType();
        $contactType->setName($this->contactTypeName);
        $manager->persist($contactType);
        $manager->flush();
    }
}
