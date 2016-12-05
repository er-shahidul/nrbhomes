<?php
namespace AppBundle\Form;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Test\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;


class PurchasedLandRelationType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('purchasedTotalArea',TextType::class)
            ->add('newDagNumber',TextType::class,
                array(
                    'required'=>false
                ))
            ->add('dagNumber', EntityType::class,
                array(
                    'choice_label' => 'dag_number',
                    'attr' => array('class' => 'form-control select2'),
                    'class' => 'AppBundle\Entity\DagNumber',
                    'placeholder' => 'Select',
                    'query_builder' => function(\Doctrine\ORM\EntityRepository $er) {
                        $qb = $er->createQueryBuilder('d')->orderBy('d.dagNumber', 'asc');
                        return $qb;
                    },
                    'required'=>false
                )
            )
            ->add('mouza', EntityType::class,
                array(
                    'choice_label' => 'name',
                    'attr' => array('class' => 'form-control select2'),
                    'class' => 'AppBundle\Entity\Mouza',
                    'placeholder' => 'Select',
                    'query_builder' => function(\Doctrine\ORM\EntityRepository $er) {
                        $qb = $er->createQueryBuilder('m')->where('m.approved=1')->orderBy('m.name', 'asc');
                        return $qb;
                    },
                    'required'=>false
                )
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\PurchasedLandRelation'
        ));
    }

    public function getName()
    {
        return 'purchased_land_relation';
    }


}