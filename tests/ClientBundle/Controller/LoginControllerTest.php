<?php

namespace tests\ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use ClientBundle\DataFixtures\ORM\LoadUserData;
use Symfony\Component\BrowserKit\Client;

class LoginControllerTest extends WebTestCase
{
    /** @var Client */
    private $client;

    /** @var  LoadUserData */
    private $loadUser;

    private $em;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function testRedirect()
    {
        $this->client->request('GET', '/');
        $this->assertTrue($this->client->getResponse()->isRedirect('http://localhost/login'));
        $this->assertContains('Redirecting to', $this->client->getResponse()->getContent());
        $this->assertEquals(Response::HTTP_FOUND, $this->client->getResponse()->getStatusCode());
    }

    public function testLoginPageLoaded()
    {
        $crawler = $this->client->request('GET', '/login');
        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertGreaterThan(4, $crawler->filter('input')->count());
    }

    public function testLoginFormPass()
    {
        $this->em = $this->client->getContainer()->get('doctrine')->getManager();
        $this->loadUser = new LoadUserData();
        $this->loadUser->load($this->em);

        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('_submit')->form();
        $this->client->submit($form, ['_username' => $this->loadUser->getUserName(), '_password' => $this->loadUser->getUserPass()]);
        $this->assertTrue($this->client->getResponse()->isRedirect('http://localhost/'));

        $this->loadUser->removeUser($this->em);
    }

    public function testLoginFormFail()
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('_submit')->form();
        $this->client->submit($form, ['_username' => 'wtf', '_password' => 'wtf']);
        $this->assertTrue($this->client->getResponse()->isRedirect('http://localhost/login'));
    }
}