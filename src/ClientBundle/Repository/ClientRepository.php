<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 21.11.2016
 * Time: 10:07
 */

namespace ClientBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ClientRepository extends EntityRepository
{
    public function getIdArrayByTags($tags)
    {
        $tagsarray = implode(', ', $tags);
        return $this->getEntityManager()
            ->createQuery("'SELECT c.id FROM ClientBundle:Client c WHERE'")
            ->setParameter('tag', $tagsarray)
            ->getResult();
    }
}