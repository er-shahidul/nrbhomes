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

    private function religionList()
    {
        return array(
            'ইসলাম' => 'ইসলাম',
            'হিন্দু' => 'হিন্দু',
            'বৌদ্ধ' => 'বৌদ্ধ',
            'খ্রীস্টান' => 'খ্রীস্টান',
            'প্রকাশ করতে অস্বীকার' => 'প্রকাশ করতে অস্বীকার',
            'নাস্তিক' => 'নাস্তিক',
            'অন্যান্য' => 'অন্যান্য',
        );
    }

    private function educationLevelList()
    {
        return array(
            'এস এস সি' => 'এস এস সি',
            'এইচ এস সি' => 'এইচ এস সি',
            'বি এস সি' => 'বি এস সি',
            'বি এস সি(অনার্স)' => 'বি এস সি(অনার্স)',
            'বি এ' => 'বি এ',
            'বি এ(অনার্স)' => 'বি এ(অনার্স)',
            'বি কম' => 'বি কম',
            'বি কম(অনার্স)' => 'বি কম(অনার্স)',
            'এম এ' => 'এম এ',
            'এম এস সি' => 'এম এস সি',
            'এম কম' => 'এম কম',
            'পি এইচ ডি' => 'পি এইচ ডি',
            'এম বি বি এস' => 'এম বি বি এস',
        );
    }

    private function disabilityList()
    {
        return array(
            'সমস্যা নেই' => 'সমস্যা নেই',
            'বাক' => 'বাক',
            'দৃষ্টি' => 'দৃষ্টি',
            'শ্রবন' => 'শ্রবন',
            'শারিরিক' => 'শারিরিক',
            'মানসিক' => 'মানসিক',
        );
    }

    private function bloodGroupList()
    {
        return array(
            'O+ (O Positive)' => 'O+ (O Positive)',
            'O- (O Negative)' => 'O-  (O Negative)',
            'A+ (A Positive)' => 'A+ (A Positive)',
            'A-	(A Negative)' => 'A- (A Negative)',
            'B+ (B Positive)' => 'B+ (B Positive)',
            'B- (B Negative)' => 'B- (B Negative)',
            'AB+ (AB Positive)' => 'AB+ (AB Positive)',
            'AB- (AB  Negative)' => 'AB- (AB Negative)',
        );
    }
}
