<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 28.11.2016
 * Time: 19:29
 */

namespace ClientBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use ClientBundle\Entity\Contact;

class ContactAdmin extends AbstractAdmin
{
    protected $parentAssociationMapping = 'client';

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('type', 'entity', array(
                'class' => 'ClientBundle:ContactType',
                'choice_label' => 'name'))
            ->add('mean')
        /*
            ->add('client', 'entity', array(
                'class' => 'ClientBundle:Client',
                'choice_label' => 'getDisplayName',
                'multiple' => false,
            ))
        */
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('type', null, array(), 'entity', null, array('label' => 'Newtypecontact'))
            ->add('mean', null, array(), 'text', null, array('label'=> 'Newmeancontact'))
            ->add('client', null, array(), 'entity', null, array('class' => 'ClientBundle:Client',
                                                                 'choice_label' => 'getDisplayName'))
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('getDisplayName', 'text', array(
            'label' => 'Newmeancontact'))
            ->add('client', 'entity', array('class' => 'ClientBundle:Client', 'choice_label' => 'getDisplayName'))

        ;
    }

    public function toString($object)
    {
        return $object instanceof Contact
            ? $object->getDisplayName()
            : 'Контакт';
    }
}