<?php

namespace tests\ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Client;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Response;
use ClientBundle\DataFixtures\ORM\LoadUserData;

class ClientControllerTest extends WebTestCase
{
    /** @var Client */
    private $client = null;

    /** @var Crawler */
    private $crawler;

    /** @var  LoadUserData */
    private $loadUser;

    private $em;

    public function setUp()
    {
        $this->client = static::createClient();

        $this->em = $this->client->getContainer()->get('doctrine')->getManager();
        $this->loadUser = new LoadUserData();
        $this->loadUser->load($this->em);

        $this->crawler = $this->client->request('GET', '/login');
        $form = $this->crawler->selectButton('_submit')->form();
        $this->client->submit($form, ['_username' => $this->loadUser->getUserName(), '_password' => $this->loadUser->getUserPass()]);
    }

    public function testClientPage()
    {
        $this->crawler = $this->client->request('GET', '/');
        $this->assertCount(1, $this->crawler->selectButton('BtnAddClient'));
    }

    public function testAddClientBtnPress()
    {
        $this->crawler = $this->client->request('GET', '/client_add');
        $this->assertCount(0, $this->crawler->selectButton('BtnAddClient'));
        $this->assertEquals('http://localhost/client_add', $this->crawler->getBaseHref());
    }

    public function testAddClientFail()
    {
        $this->crawler = $this->client->request('GET', '/client_add');
        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $form = $this->crawler->selectButton('client_form_Save')->form();
        $this->assertCount(1, $this->crawler->selectButton('client_form_Save'));

        $form['client_form[firstname]'] = 'testName';
        $form['client_form[surname]'] = 'testSurName';

        $form['client_form[birthday][day]'] = 25;
        $form['client_form[birthday][month]'] = 13;
        $form['client_form[birthday][year]'] = 2000;

        $form['client_form[description]'] = 'some description';
        //todo add category fixture
        $form['client_form[categories]']->setValue(1);
        //todo add language fixture
        $form['client_form[language]']->setValue(2);
        $this->client->submit($form);

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
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
