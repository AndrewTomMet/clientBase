<?php

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class Test
 */
class Test extends WebTestCase
{
    public function testOnePlusOne()
    {
        $this->assertEquals(1+1, 1);
    }
}
