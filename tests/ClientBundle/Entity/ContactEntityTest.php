<?php

namespace tests\ClientBundle\Entity;

use ClientBundle\Entity\Client;
use ClientBundle\Entity\Contact;
use ClientBundle\Entity\ContactType;

/**
 * Class ContactEntityTest
 * @package tests\ClientBundle\Entity
 */
class ContactEntityTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     */
    public function testSetGetMean()
    {
        $mean = 'mean';
        $contact = new Contact();
        $this->assertEmpty($contact->getMean());
        $contact->setMean($mean);
        $this->assertEquals($mean, $contact->getMean());
    }

    /**
     *
     */
    public function testSetGetType()
    {
        $contact = new Contact();
        $contactType = new ContactType();
        $this->assertEmpty($contact->getType());
        $contact->setType($contactType);
        $this->assertEquals($contactType, $contact->getType());
    }

    /**
     *
     */
    public function testGetDisplayName()
    {
        $mean = 'mean';
        $contactTypeName = 'email';
        $contact = new Contact();
        $contactType = new ContactType();
        $contactType->setName($contactTypeName);
        $this->assertEmpty($contact->getDisplayName());

        $contact->setType($contactType);
        $this->assertEquals($contactTypeName, $contact->getDisplayName());

        $contact->setMean($mean);
        $this->assertEquals($contactTypeName.': '.$mean, $contact->getDisplayName());
    }

    /**
     *
     */
    public function testSetGetClient()
    {
        $client = new Client();
        $contact = new Contact();
        $this->assertEmpty($contact->getClient());

        $contact->setClient($client);
        $this->assertEquals($client, $contact->getClient());
    }

    /**
     *
     */
    public function testToString()
    {
        $mean = 'mean';
        $contact = new Contact();
        $this->assertEmpty($contact->__toString());
        $contact->setMean($mean);
        $this->assertEquals($mean, $contact->__toString());
    }
}
