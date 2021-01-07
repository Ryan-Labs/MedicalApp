<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdatePasswordUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('newPassword', RepeatedType::class, array(
                    'type' => PasswordType::class,
                    'first_options' => array(
                        'attr' => ['placeholder' => 'New Password'],
                        'label' => false,
                    ),
                    'second_options' => array(
                        'attr' => ['placeholder' => 'Repeat New Password'],
                        'label' => false,
                    ),
                    'mapped' => false,
                )
            )
            ->add('password', PasswordType::class, array(
                    'mapped' => false,
                    'attr' => ['placeholder' => 'Password'],
                    'label' => false,
                )
            )
            ->add('submit', SubmitType::class, array(
                    'label' => 'Envoyer',
                )
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
