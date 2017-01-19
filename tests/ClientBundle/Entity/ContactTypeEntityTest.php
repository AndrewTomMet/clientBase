<?php

namespace tests\ClientBundle\Entity;

use ClientBundle\Entity\ContactType;

/**
 * Class ContactTypeEntityTest
 */
class ContactTypeEntityTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     */
    public function testSetGetName()
    {
        $name = 'name';
        $contactType = new ContactType();
        $this->assertEmpty($contactType->getName());

        $contactType->setName($name);
        $this->assertEquals($name, $contactType->getName());
    }

    /**
     *
     */
    public function testToString()
    {
        $name = 'name';
        $contactType = new ContactType();
        $this->assertEmpty($contactType->__toString());

        $contactType->setName($name);
        $this->assertEquals($name, $contactType->__toString());
    }
}
