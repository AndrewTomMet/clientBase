<?php

namespace tests\ClientBundle\Repository;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use ClientBundle\DataFixtures\ORM\LoadContactType;

class ContactTypeRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

   /** @var LoadContactType*/
    private $loadContactType;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        self::bootKernel();

        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();
        $this->loadContactType->removeContactType($this->em);
        $this->em->close();
        $this->em = null;
    }

    public function testGetAllIdArray()
    {
        $this->loadContactType = new LoadContactType();
        $this->loadContactType->load($this->em);

        $idArray = $this->em->getRepository('ClientBundle:ContactType')->getAllIds();
        $this->assertGreaterThan(0, count($idArray));
    }
}