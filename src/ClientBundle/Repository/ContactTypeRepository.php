<?php

namespace ClientBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class ContactTypeRepository
 */
class ContactTypeRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function getAllIds()
    {
        $result = $this->getEntityManager()
            ->createQuery('SELECT ct.id FROM ClientBundle:ContactType ct')
            ->getResult();

        return array_column($result, 'id');
    }
}
