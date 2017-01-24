<?php

namespace tests\ClientBundle;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Client;
use ClientBundle\DataFixtures\ORM\LoadUserData;

class ApplicationAvailabilityFunctionalTest extends WebTestCase
{
    /** @var Client */
    private $client = null;

    /** @var  LoadUserData */
    private $loadUser;
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    public function setUp()
    {
        $this->client = static::createClient();

        $this->em = $this->client->getContainer()->get('doctrine')->getManager();
        $this->loadUser = new LoadUserData();
        $this->loadUser->load($this->em);

        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('_submit')->form();
        $this->client->submit($form, ['_username' => $this->loadUser->getUserName(), '_password' => $this->loadUser->getUserPass()]);
    }

    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful($url)
    {
        $this->client->request('GET', $url);

        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }

    public function urlProvider()
    {
        return [
            ['/'],
            ['/login'],
            ['/client_add'],
            ['/categories'],
            ['/categories_add'],
            ['/lang'],
            ['/lang_add'],
            ['/contacttype'],
            ['/contacttype_add'],
        ];
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();
        $this->loadUser->removeUser($this->em);
        $this->em->close();
        $this->em = null;
    }
}