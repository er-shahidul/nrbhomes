<?php
namespace AppBundle\Form;


use AppBundle\Entity\PurchasedLandRelation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
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
            ->add('landOwnerName', TextType::class)
            ->add('address', TextType::class)
            ->add('landType', TextType::class)
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