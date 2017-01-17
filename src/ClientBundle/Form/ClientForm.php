<?php

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
use Symfony\Component\Form\CallbackTransformer;

/**
 * Class ClientForm
 */
class ClientForm extends AbstractType
{
    private $clientId;

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->clientId = $options['id'];
        $builder
            ->add('created_at', DateType::class, ['widget' => 'text',
                                                        'required' => false,
                                                        'format' => 'dd-MM-yyyy',
                                                        'disabled' => true,
            ])
            ->add('firstname', TextType::class)
            ->add('surname', TextType::class, ['required' => false])
            ->add('birthday', BirthdayType::class, [
                'format' => 'dd-MM-yyyy',
                'placeholder' => 'dd-mm-yyyy',
                'widget' => 'text',
                'required' => false,
            ])
            ->add('description', TextareaType::class, ['required' => false])
            ->add('categories', EntityType::class, [
                'class' => 'ClientBundle:Category',
                'choice_label' => 'name',
                'multiple' => true,
                'required' => false,
            ])
            ->add('language', EntityType::class, [
                'class'   => 'ClientBundle:Lang',
                'choice_label' => 'name',
                'multiple' => false,
            ])
            ->add('contacts', EntityType::class, [
                'class' => 'ClientBundle:Contact',
                'query_builder' => function (EntityRepository $er) {
                    if ($this->clientId != -1) {
                        return $er->createQueryBuilder('u')
                            ->select(array('u'))
                            ->where('u.client = :id')
                            ->orderBy('u.type', 'ASC')
                            ->setParameter('id', $this->clientId);
                    } else {
                        return $er->createQueryBuilder('u')->orderBy('u.type', 'ASC');
                    }
                },
                'choice_label' => 'getDisplayName',
                'multiple' => true,
                'required' => false,
            ])
            ->add('newtypecontact', EntityType::class, [
                'class' => 'ClientBundle:ContactType',
                'choice_label' => 'name',
                'mapped' => false,
                'required' => false,
            ])

            ->add('newmeancontact', TextType::class, [
                'mapped' => false,
                'required' => false,
            ])
            ->add('addcontact', SubmitType::class)
            ->add('tags', TextType::class, ['required' => false])
            ->add('Save', SubmitType::class)
        ;

        $builder->get('tags')
            ->addModelTransformer(new CallbackTransformer(
                function ($tagsAsArray) {
                    if ($tagsAsArray) {
                        return implode(', ', $tagsAsArray);
                    } else {
                        return '';
                    }
                },
                function ($tagsAsString) {
                    return explode(', ', $tagsAsString);
                }
            ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired(['id']);
        if ($resolver->isMissing('id')) {
            $resolver->setDefault('id', -1);
        }
    }
}
