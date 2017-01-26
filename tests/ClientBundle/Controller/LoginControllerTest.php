<?php

namespace tests\ClientBundle\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\BrowserKit\Client;

class LoginControllerTest extends WebTestCase
{
    /** @var Client */
    private $client;

    private $userName = 'testadmin';
    private $userPass = 'testpass';

    public function setUp()
    {
        $this->client = $this->createClient();
        $this->loadFixtures(['ClientBundle\DataFixtures\ORM\LoadUserData']);
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
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('_submit')->form();
        $this->client->submit($form, ['_username' => $this->userName, '_password' => $this->userPass]);
        $this->assertTrue($this->client->getResponse()->isRedirect('http://localhost/'));
    }

    public function testLoginFormFail()
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('_submit')->form();
        $this->client->submit($form, ['_username' => 'wtf', '_password' => 'wtf']);
        $this->assertTrue($this->client->getResponse()->isRedirect('http://localhost/login'));
    }
}