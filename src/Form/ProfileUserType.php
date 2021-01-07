<?php

namespace App\Form;

use App\Entity\Profession;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ProfileUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('salutation', ChoiceType::class, array(
                    'choices' => ['M.' => 'Male', 'Mme' => 'Female'],
                    'required' => false,
                    'label' => "Sex"
            ))
            ->add('firstName', TextType::class, array(
                'label' => 'Prenom',
                'attr' => array('name' => 'firstName',)

            ))
            ->add('lastName', TextType::class, array(
                'label' => 'Nom',
                'attr' => array('name' => 'lastName',)

            ))
            ->add('phoneNumber', TelType::class, array(
                'label' => 'Numero de Tel.',
            ))
            ->add('professions', RepeatedType::class ,
                array(
                    'type'=> EntityType::class,
                    'first_options' => array(
                        'class' => Profession::class,
                        'choice_label' => 'name',
                        'expanded' => true,
                        'multiple' => true,
                        'label' => "Jobs",
                    ),
                    'second_options' => array(
                        'class' => Profession::class,
                        'choice_label' => 'name',
                        'multiple' => true,
                        'label' => "Ajouter un job",

                    ),
                )
            )
            ->add('submit', SubmitType::class, array(
                'label' => 'Valider'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
