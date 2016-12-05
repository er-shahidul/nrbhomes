<?php
namespace AppBundle\Form;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;


class MouzaType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,
                    array(
                        'attr'  => array('class'=>'form-control'),
                        'required'=> true,
                        'constraints'=>new NotBlank()
                    )
                )
            ->add('bbsGeocode',TextType::class,
                array(
                    'attr'  => array('class'=>'form-control'),
                ))
            ->add('upozila', EntityType::class,
                array(
                    'choice_label' => 'name',
                    'attr' => array('class' => 'form-control select2'),
                    'class' => 'AppBundle\Entity\Upozila',
                    'placeholder' => 'Select',
                    'query_builder' => function(\Doctrine\ORM\EntityRepository $er) {
                        $qb = $er->createQueryBuilder('u')->orderBy('u.name', 'asc');
                        return $qb;
                    },
                    'constraints' => new NotBlank(),
                    'required'=> true
                )
            )
            ;

    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Mouza'
        ));
    }

    public function getName()
    {
        return 'mouza_entity';
    }


}