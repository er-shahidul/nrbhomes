<?php
namespace AppBundle\Form;

use AppBundle\Entity\DagNumber;
use AppBundle\Entity\Mouza;
use AppBundle\Entity\PurchasedLandRelation;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
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
            ->add('purchasedTotalArea',TextType::class,
                array(
                    'attr' => array('class' => 'form-control purchased_total_area'),
                ))
            ->add('mouza', EntityType::class,
                array(
                    'choice_label' => 'name',
                    'attr' => array('class' => 'form-control mouza_list'),
                    'class' => 'AppBundle\Entity\Mouza',
                    'placeholder' => 'Select',
                    'query_builder' => function(\Doctrine\ORM\EntityRepository $er) {
                        $qb = $er->createQueryBuilder('m')->where('m.approved=1')->orderBy('m.name', 'asc');
                        return $qb;
                    },
                )
            )
        ;


        $formModifier =  function (FormInterface $form, Mouza $mouza = null) {
            $dagNumbers = null === $mouza ? array() : $mouza->getDagNumbers();

            $form->add('dagNumber', EntityType::class, array(
                'class'       => 'AppBundle:DagNumber',
                'attr' => array('class' => 'form-control dag_number_list'),
                'placeholder' => 'Select',
                'choices'     => $dagNumbers,
            ));
        };

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {

                $data = $event->getData();
                $formModifier($event->getForm(), $data == null ? null : $data->getMouza());
            }
        );

        $builder->get('mouza')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                $mouza = $event->getForm()->getData();
                $formModifier($event->getForm()->getParent(), $mouza);
            }
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