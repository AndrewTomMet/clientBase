<?php

namespace tests\ClientBundle\Browser;

use aik099\PHPUnit\BrowserTestCase;

class GeneralTest extends BrowserTestCase
{
    public static $browsers = array(
        array(
            'driver' => 'selenium2',
            'host' => 'localhost',
            'port' => 80,
            'browserName' => 'firefox',
            'baseUrl' => '/',
        ),
    );

    public function testUsingSession()
    {
        /*
        $session = $this->getSession();
        $session->visit('/');
        $this->assertTrue($session->getPage()->hasContent(''));
        */
    }

    public function testUsingBrowser()
    {

        echo sprintf(
            "I'm executed using '%s' browser",
            $this->getBrowser()->getBrowserName()
        );

    }
}
