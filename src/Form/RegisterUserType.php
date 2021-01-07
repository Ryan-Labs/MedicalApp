<?php

namespace App\Form;

use App\Entity\Profession;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, array(
                'label' => 'Prenom',
                'attr' => array('name' => 'firstName',)
            ))
            ->add('lastName', TextType::class, array(
                'label' => 'Nom',
                'attr' => array('name' => 'lastName',)
            ))
            ->add('salutation', ChoiceType::class,
                array(
                    'choices' => array(
                        'Monsieur' => 'Male',
                        'Madame' => 'Female',
                    ),
                    'expanded'=>true,
                    'label' => 'Titre'
                ))
            ->add('mail', EmailType::class, array(
                'label' => 'Email',
            ))
            ->add('password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options' => array('label' => 'Password'),
                'second_options' => array('label' => 'Repeat password'),
            ))
            ->add('phoneNumber',TelType::class, array(
                'label' => 'Numero de Tel.',
                'required' => false,
            ))
            ->add('professions', EntityType::class ,array(
                'class' => Profession::class,
                'choice_label' => 'name',
                'multiple' => true
            ))

            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
