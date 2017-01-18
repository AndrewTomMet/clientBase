<?php

namespace ClientBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use ClientBundle\Entity\Lang;

/**
 * Class LangAdmin
  */
class LangAdmin extends AbstractAdmin
{
    /**
     * @param mixed $object
     * @return string
     */
    public function toString($object)
    {
        return $object instanceof Lang
            ? $object->getName()
            : 'Мова';
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper ->add('name');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper ->add('name');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('name');
    }
}
