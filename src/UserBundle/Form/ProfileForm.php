<?php

namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ProfileForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fullNameEn', TextType::class)
            ->add('fullNameBn', TextType::class,array(
                'required'=>false,
            ))
            ->add('nid', TextType::class,array(
                'required'=>false,
            ))
            ->add('cellphone')

            ->add('gender', ChoiceType::class, array(
                'choices' => array('Male' => 'Male', 'Female' => 'Female', 'Other' => 'Other'),
                'expanded' => true,
                'multiple' => false
            ))
            ;

        $builder->add('fathersFullNameBn', TextType::class,array(
            'required'=>false,
        ));
        $builder->add('currentAddress');
        $builder->add('permanentAddress');

    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UserBundle\Entity\Profile'
        ));
    }

    public function getName()
    {
        return 'user_profile';
    }

}
