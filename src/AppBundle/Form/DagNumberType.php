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


class DagNumberType extends AbstractType
{

    private $mouzaId;


    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->mouzaId= $options['mouzaId'];
        $builder
            ->add('dagNumberName',TextType::class,
                    array(
                        'attr'  => array('class'=>'form-control'),
                        'required'=> true,
                        'constraints'=>new NotBlank()
                    )
                )
            ->add('dagTotalArea',TextType::class,
                array(
                    'attr'  => array('class'=>'form-control'),
                ))
            ->add('mouza', EntityType::class,
                array(
                    'choice_label' => 'name',
                    'attr' => array('class' => 'form-control select2'),
                    'class' => 'AppBundle\Entity\Mouza',
                    'data' => $this->mouzaId,
                    'placeholder' => 'Select',
                    'query_builder' => function(\Doctrine\ORM\EntityRepository $er) {
                        $qb = $er->createQueryBuilder('m')->where('m.approved=1')->orderBy('m.name', 'asc');
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
            'data_class' => 'AppBundle\Entity\DagNumber',
            'mouzaId' => 0
        ));
    }

    public function getName()
    {
        return 'dag_number_entity';
    }


}