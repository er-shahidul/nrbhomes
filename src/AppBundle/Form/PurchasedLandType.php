<?php
namespace AppBundle\Form;


use AppBundle\Entity\PurchasedLandRelation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class PurchasedLandType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('landOwnerName', TextType::class,array(
                'attr' => array('class' => 'form-control')
            ))
            ->add('address',TextareaType::class ,array(
                'attr' => array('class' => 'form-control'),
                'required'=>false
            ))
            ->add('totalAmount', TextType::class,array(
                'attr' => array('class' => 'form-control')
            ))
            ->add('paidAmount', TextType::class,array(
                'attr' => array('class' => 'form-control'),
                'required'=>false
            ))
            ->add('landType', ChoiceType::class, array(
                'attr' => array('class' => 'form-control select2 land_type'),
                'choices'  => array( 'Private Property' => 'PRIVATE', 'Demesne' => 'DEMESNE', 'Vested Property' => 'VESTED'),
//                'placeholder' => 'Select',
            ))

            ->add('leased', ChoiceType::class, array(
                'choices' => array('Yes' => 1, 'No' => 0),
                'expanded' => true,
                'multiple' => false
            ))

            ->add('purchased', ChoiceType::class, array(
                'choices' => array('Yes' => 1, 'No' => 0),
                'expanded' => true,
                'multiple' => false
            ))
            ->add('leasedInfo', LeasedInfoType::class)

            ->add('purchasedLandRelation', CollectionType::class, array(
                'entry_type' => PurchasedLandRelationType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'prototype' => true,
                'by_reference' => false,
                'label_attr' => array(
                    'class' => 'hidden'
                )
            ))
            ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\PurchasedLand'
        ));
    }

    public function getName()
    {
        return 'purchased_land';
    }


}