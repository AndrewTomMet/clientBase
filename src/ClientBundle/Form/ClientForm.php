<?php

/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 21.11.2016
 * Time: 10:53
 */

namespace ClientBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;


class ClientForm extends AbstractType
{
    private $client_id;
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->client_id = $options['id'];
        $builder
            ->add('created_at',DateType::class, array('widget' => 'text',
                                                        'required' => false,
                                                        'format' => 'dd-MM-yyyy',
                                                        'disabled' => true  ))
            ->add('firstname', TextType::class)
            ->add('surname',TextType::class, array('required' => false))
            ->add('birthday',BirthdayType::class, array(
                'format' => 'dd-MM-yyyy',
                'placeholder'=>'dd-mm-yyyy',
                'widget' => 'text','required' => false ))

            ->add('description',TextareaType::class, array('required' => false))
            ->add('categories',EntityType::class, array(
                'class'   => 'ClientBundle:Category',
                'choice_label' => 'name',
                'multiple' => true,
                'required' => false
                ))

            ->add('language', EntityType::class, array(
                'class'   => 'ClientBundle:Lang',
                'choice_label' => 'name',
                'multiple' => false,
                ))

            ->add('contacts', EntityType::class, array(
                'class'   => 'ClientBundle:Contact',
                'query_builder' =>
                 function (EntityRepository $er)
                {
                    if ( $this->client_id != -1 ){
                        return $er->createQueryBuilder('u')
                            ->select(array('u'))
                            ->where('u.client = :id')
                            ->orderBy('u.type', 'ASC')
                            ->setParameter('id', $this->client_id );
                    } else
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.type', 'ASC');
                },
                'choice_label' => 'getDisplayName',
                'multiple' => true,
                'required' => false
                ))

            ->add('newtypecontact', EntityType::class, array(
                'class'   => 'ClientBundle:ContactType',
                'choice_label' => 'name',
                'mapped'=>false,
                'required' => false))

            ->add('newmeancontact', TextType::class, array(
                'mapped'=>false,
                'required' => false))

            ->add('addcontact', SubmitType::class)

            ->add('Save', SubmitType::class)
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired(array(
            'id'
        ));
        if ($resolver->isMissing('id')) {
            $resolver->setDefault('id',-1);
        }

    }
}