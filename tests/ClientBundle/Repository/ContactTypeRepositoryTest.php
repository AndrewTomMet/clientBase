<?php

namespace tests\ClientBundle\Repository;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class ContactTypeRepositoryTest extends WebTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        $this->em = $this->getContainer()->get('doctrine')->getManager();
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testGetAllIdArray()
    {
        $this->loadFixtures(['ClientBundle\DataFixtures\ORM\LoadContactType']);
        $idArray = $this->em->getRepository('ClientBundle:ContactType')->getAllIds();
        $this->assertGreaterThan(0, count($idArray));
    }
}