<?php

namespace tests\ClientBundle\Entity;

use ClientBundle\Entity\Category;
use ClientBundle\Entity\Client;

class CategoryEntityTest extends \PHPUnit_Framework_TestCase
{
    public function testAddRemoveClient()
    {
        $client = new Client();
        $category = new Category();

        $this->assertCount(0, $category->getClients());
        $category->addClient($client);
        $this->assertCount(1, $category->getClients());
        $category->removeClient($client);
        $this->assertCount(0, $category->getClients());
    }

    public function testGetSetName()
    {
        $category = new Category();
        $this->assertEmpty($category->getName());
        $category->setName('test1');
        $this->assertEquals('test1', $category->getName());
    }

    public function testToString()
    {
        $category = new Category();
        $this->assertEmpty($category->__toString());
        $category->setName('test1');
        $this->assertEquals('test1', $category->__toString());
    }
}
