<?php

namespace ClientBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use ClientBundle\Entity\Category;

/**
 * Class LoadCategoryData
 */
class LoadCategoryData extends AbstractFixture
{
    private $categoryName = 'testCategory';

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $category = new Category();
        $category->setName($this->categoryName);
        //$this->setReference('category', $category);
        $manager->persist($category);
        $manager->flush();
    }
}
