<?php

namespace ClientBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ClientBundle\Entity\Lang;

/**
 * Class LoadLanguageData
 */
class LoadLanguageData implements FixtureInterface
{
    private $langName = 'ukraine';

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $language = new Lang();
        $language->setName($this->langName);
        $manager->persist($language);
        $manager->flush();
    }
}