<?php

namespace tests\ClientBundle;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Client;

class ApplicationAvailabilityFunctionalTest  extends WebTestCase
{
    /** @var Client */
    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient();
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('_submit')->form();
        $this->client->submit($form, ['_username' => 'sysadmin', '_password' => 'sysadmin']);
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
}