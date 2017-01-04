<?php
namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
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
            ->add('deedDate',DateType::class ,array(
                'attr' => array('class' => 'form-control'),
                'required'=>false,
                'widget'=>'single_text',
                'format'=>'yyyy-MM-dd'
            ))
            ->add('deedDuration', TextType::class,array(
                'attr' => array('class' => 'form-control'),
                'required'=>false
            ))
            ->add('leaseStartDate', DateType::class,array(
                'attr' => array('class' => 'form-control'),
                'widget'=>'single_text',
                'format'=>'yyyy-MM-dd',
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