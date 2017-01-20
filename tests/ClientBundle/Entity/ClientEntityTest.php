<?php

namespace tests\ClientBundle\Entity;

use ClientBundle\Entity\Category;
use ClientBundle\Entity\Client;
use ClientBundle\Entity\Contact;
use ClientBundle\Entity\Lang;

class ClientEntityTest extends \PHPUnit_Framework_TestCase
{
    public function testSetGetTags()
    {
        $checkString = 'new tag';
        $client = new Client();
        $this->assertEmpty($client->getTags());
        $tags[] = $checkString;
        $client->setTags($tags);
        $this->assertEquals([$checkString], $client->getTags());
    }

    public function testSetGetFirstName()
    {
        $checkString = 'FirstName';
        $client = new Client();
        $this->assertEmpty($client->getFirstname());
        $client->setFirstname($checkString);
        $this->assertEquals($checkString, $client->getFirstname());
    }

    public function testSetGetSurname()
    {
        $checkString = 'Surname';
        $client = new Client();
        $this->assertEmpty($client->getSurname());
        $client->setSurname($checkString);
        $this->assertEquals($checkString, $client->getSurname());
    }

    public function testGetDisplayName()
    {
        $checkStringFirstName = 'FirstName';
        $checkStringSurName = 'Surname';
        $client = new Client();
        $this->assertEmpty($client->getDisplayName());

        $client->setSurname($checkStringSurName);
        $this->assertEquals($checkStringSurName, $client->getDisplayName());

        $client->setSurname('');
        $this->assertEmpty($client->getDisplayName());
        $client->setFirstname($checkStringFirstName);
        $this->assertEquals($checkStringFirstName, $client->getDisplayName());

        $client->setSurname($checkStringSurName);
        $this->assertEquals($checkStringSurName.' '.$checkStringFirstName, $client->getDisplayName());
    }

    public function testToString()
    {
        $checkStringFirstName = 'FirstName';
        $client = new Client();
        $this->assertEmpty($client->__toString());
        $client->setFirstname($checkStringFirstName);
        $this->assertEquals($checkStringFirstName, $client->__toString());
    }

    public function testSetGetBirthday()
    {
        $birthday = new \DateTime('now');
        $client = new Client();
        $this->assertEmpty($client->getBirthday());
        $client->setBirthday($birthday);
        $this->assertEquals($birthday, $client->getBirthday());
    }

    public function testSetGetCreatedAt()
    {
        $today = new \DateTime('now');
        $client = new Client();
        $client->setCreatedAt();
        $this->assertEquals($today, $client->getCreatedAt());
    }

    public function testSetGetDescription()
    {
        $description = 'Description';
        $client = new Client();
        $this->assertEmpty($client->getDescription());
        $client->setDescription($description);
        $this->assertEquals($description, $client->getDescription());
    }

    public function testAddRemoveGetContact()
    {
        $client = new Client();
        $contact = new Contact();
        $this->assertCount(0, $client->getContacts());
        $client->addContact($contact);
        $this->assertCount(1, $client->getContacts());
        $client->removeContact($contact);
        $this->assertCount(0, $client->getContacts());
    }

    public function testAddRemoveGetCategories()
    {
        $client = new Client();
        $category = new Category();
        $this->assertCount(0, $client->getCategories());
        $client->addCategory($category);
        $this->assertCount(1, $client->getCategories());
        $client->removeCategory($category);
        $this->assertCount(0, $client->getCategories());
    }

    public function testSetGetLanguage()
    {
        $client = new Client();
        $language = new Lang();
        $this->assertEmpty($client->getLanguage());
        $client->setLanguage($language);
        $this->assertEquals($language, $client->getLanguage());
    }

    public function testMock()
    {
        $client = new Client();
        $contact = new Contact();
        $client->addContact($contact);

        $validator = $this->getMock('ContainsCheckHaveAllContactTypesValidator');
        $validator->method('validate')->with($client)->will($this->returnValue(0));

    }
}
