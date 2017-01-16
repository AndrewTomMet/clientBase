<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 13.12.2016
 * Time: 10:13
 */

namespace ClientBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SeacherForm extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('searchtags', TextType::class, array('mapped'=>false))
                ->add('Search', SubmitType::class);
    }

}