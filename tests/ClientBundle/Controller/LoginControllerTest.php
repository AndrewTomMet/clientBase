<?php

namespace tests\ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class LoginControllerTest extends WebTestCase
{
    public function testRedirect()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertTrue($client->getResponse()->isRedirect('http://localhost/login'));
        $this->assertContains('Redirecting to', $client->getResponse()->getContent());
        $this->assertEquals(Response::HTTP_FOUND, $client->getResponse()->getStatusCode());
    }

    public function testLoginPageLoaded()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertGreaterThan(4, $crawler->filter('input')->count());
    }

    public function testLoginFormPass()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('_submit')->form();
        $client->submit($form, ['_username' => 'sysadmin', '_password' => 'sysadmin']);
        $this->assertTrue($client->getResponse()->isRedirect('http://localhost/'));
    }

    public function testLoginFormFail()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('_submit')->form();
        $client->submit($form, ['_username' => 'wtf', '_password' => 'wtf']);
        $this->assertTrue($client->getResponse()->isRedirect('http://localhost/login'));
    }
}