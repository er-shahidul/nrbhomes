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


class PlotRecordType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('plotName', TextType::class,array(
                'attr' => array('class' => 'form-control')
            ))
            ->add('plotNumber', TextType::class,array(
                'attr' => array('class' => 'form-control')
            ))
            ->add('address',TextareaType::class ,array(
                'attr' => array('class' => 'form-control'),
                'required'=>false,
            ))
            ->add('totalPlotArea', TextType::class,array(
                'attr' => array('class' => 'form-control')
            ))
            ->add('plotRecordRelation', CollectionType::class, array(
                'entry_type' => PlotRecordRelationType::class,
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
            'data_class' => 'AppBundle\Entity\PlotRecord'
        ));
    }

    public function getName()
    {
        return 'plot_record';
    }


}