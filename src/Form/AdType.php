<?php

namespace App\Form;

use App\Entity\Ad;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('haveSecretariat')
            ->add('homeVisit')
            ->add('housing')
            ->add('appointments')
            ->add('software')
            ->add('houseKeeping')
            ->add('sector', ChoiceType::class, ['choices' => ['1' => '1', '2' => '2', '3' => '3'], 'required' => false])
            ->add('title')
            ->add('content', CKEditorType::class)
            ->add('address')
            ->add('streetNumber', HiddenType::class)
            ->add('route', HiddenType::class)
            ->add('locality', HiddenType::class)
            ->add('administrativeAreaLevel1', HiddenType::class)
            ->add('postalCode', HiddenType::class)
            ->add('country', HiddenType::class)
            ->add('profession')
            ->add('type')
            ->add('remunerationType', ChoiceType::class, ['choices' => ['Pourcentage' => 'Pourcentage', 'Fixe' => 'Fixe'], 'required' => false])
            ->add('contact', TextType::class, ['required' => false])
            ->add('phoneNumber', TextType::class, ['required' => false])
            ->add('mail', EmailType::class, ['required' => false])
            ->add('images', FileType::class, ['required' => false, 'multiple' => true, 'mapped' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
