<?php

namespace tests\ClientBundle;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Client;

class ApplicationAvailabilityFunctionalTest extends WebTestCase
{
    /** @var Client */
    private $client = null;
    private $userName = 'testadmin';
    private $userPass = 'testpass';

    public function setUp()
    {
        $this->client = $this->createClient();
        $this->loadFixtures(['ClientBundle\DataFixtures\ORM\LoadUserData']);

        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('_submit')->form();
        $this->client->submit($form, ['_username' => $this->userName, '_password' => $this->userPass]);
    }

    /**
     * @dataProvider urlProvider
     * @param string $url
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
    }
}