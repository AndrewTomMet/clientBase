<?php

namespace tests\ClientBundle\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Client;
use Symfony\Component\DomCrawler\Crawler;
use ClientBundle\DataFixtures\ORM\LoadUserData;

class ClientControllerTest extends WebTestCase
{
    /** @var Client */
    private $client = null;

    /** @var Crawler */
    private $crawler;

    private $userName = LoadUserData::TESTUSERNAME;
    private $userPass = LoadUserData::TESTUSERPASS;

    public function setUp()
    {
        $connection = $this->getContainer()->get('doctrine')->getConnection();

        $connection->exec("DELETE FROM client;");
        $connection->exec("ALTER TABLE client AUTO_INCREMENT = 1;");

        $connection->exec("DELETE FROM languages;");
        $connection->exec("ALTER TABLE languages AUTO_INCREMENT = 1;");

        $connection->exec("DELETE FROM category;");
        $connection->exec("ALTER TABLE category AUTO_INCREMENT = 1;");

        $this->client = $this->createClient();
        $this->loadFixtures([
            'ClientBundle\DataFixtures\ORM\LoadUserData',
            'ClientBundle\DataFixtures\ORM\LoadCategoryData',
            'ClientBundle\DataFixtures\ORM\LoadLanguageData',
        ]);

        $this->crawler = $this->client->request('GET', '/login');
        $form = $this->crawler->selectButton('_submit')->form();
        $this->client->submit($form, ['_username' => $this->userName, '_password' => $this->userPass]);
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
        $form['client_form[birthday][month]'] = 12;
        $form['client_form[birthday][year]'] = 2000;
        $form['client_form[description]'] = 'some description';

        $form['client_form[language]']->select(1);
        $form['client_form[categories]']->select([1]);

        $this->client->submit($form);
        $this->assertTrue($this->client->getResponse()->isRedirect('/'));
        $this->client->followRedirect();
        $this->assertContains('Додати кліента', $this->client->getResponse()->getContent());
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();
    }
}
