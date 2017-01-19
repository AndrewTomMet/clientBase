<?php

namespace tests\ClientBundle\Entity;

use ClientBundle\Entity\Lang;

class LangEntityTest extends \PHPUnit_Framework_TestCase
{
    public function testSetGetName()
    {
        $name = 'name';
        $lang = new Lang();
        $this->assertEmpty($lang->getName());

        $lang->setName($name);
        $this->assertEquals($name, $lang->getName());
    }

    public function testToString()
    {
        $name = 'name';
        $lang = new Lang();
        $this->assertEmpty($lang->__toString());

        $lang->setName($name);
        $this->assertEquals($name, $lang->__toString());
    }
}
