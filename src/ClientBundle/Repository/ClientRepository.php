<?php

namespace ClientBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class ClientRepository
 */
class ClientRepository extends EntityRepository
{
    /**
     * @param $tags
     * @return array
     */
    public function getIdArrayByTags($tags)
    {
        $tagsarray = implode(', ', $tags);

        return $this->getEntityManager()
            ->createQuery("'SELECT c.id FROM ClientBundle:Client c WHERE'")
            ->setParameter('tag', $tagsarray)
            ->getResult();
    }
}
