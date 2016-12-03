<?php

/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 18.11.2016
 * Time: 8:59
 */

namespace ClientBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CategoriesForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('categories',EntityType::class, array(
            'class'   => 'ClientBundle:Category',
            'choice_label' => 'name',
            'multiple' => false,
            'required' => false
        ))->add('go', SubmitType::class);
    }

}