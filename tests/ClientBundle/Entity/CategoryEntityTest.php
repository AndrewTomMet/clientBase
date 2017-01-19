<?php

namespace tests\ClientBundle\Entity;

use ClientBundle\Entity\Category;
use ClientBundle\Entity\Client;

/**
 * Class CategoryEntityTest
 */
class CategoryEntityTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     */
    public function testCount()
    {
        $client = new Client();
        $client->setFirstname('Dev');

        $category0 = new Category();
        $category0->setName('Test0');

        $category1 = new Category();
        $category1->setName('Test1');

        $category0->addClient($client);
        $category1->addClient($client);
        $client->addCategory($category0);
        $client->addCategory($category1);
        $this->assertCount(1, $category0->getClients(), 'test category '.$category0->getName().' clients count');
        $this->assertCount(2, $client->getCategories(), 'test client '.$client->getFirstname().' category count');

        $category0->removeClient($client);
        $client->removeCategory($category0);
        $this->assertCount(0, $category0->getClients(), 'test category '.$category0->getName().' clients count');
        $this->assertCount(1, $client->getCategories(), 'test client '.$client->getFirstname().' category count');
    }
}