<?php

namespace App\Form;

use App\Entity\Ad;
use Symfony\Component\Form\AbstractType;
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
            ->add('sector')
            ->add('content')
            ->add('address')
            ->add('isActive')
            ->add('date')
            ->add('profession')
            ->add('type')
            ->add('remunerationType')
            ->add('user')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
