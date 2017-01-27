<?php

namespace ClientBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use ClientBundle\Entity\Client;

/**
 * Class LoadClientData
 */
class LoadClientData extends AbstractFixture
{
    public $clientName = 'TestClient';
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $client = new Client();
        $client->setFirstname($this->clientName);
        $manager->persist($client);
        $manager->flush();
    }
}
