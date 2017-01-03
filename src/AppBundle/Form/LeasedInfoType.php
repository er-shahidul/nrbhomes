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


class LeasedInfoType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('deedNumber', TextType::class,array(
                'attr' => array('class' => 'form-control'),
                'required'=>false
            ))
            ->add('deedDate',TextType::class ,array(
                'attr' => array('class' => 'form-control'),
                'required'=>false
            ))
            ->add('deedDuration', TextType::class,array(
                'attr' => array('class' => 'form-control'),
                'required'=>false
            ))
            ->add('leaseStartDate', TextType::class,array(
                'attr' => array('class' => 'form-control'),
                'required'=>false
            ))
            ;

    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\LeasedInfo'
        ));
    }

    public function getName()
    {
        return 'leased_info';
    }


}