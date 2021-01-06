<?php

namespace App\Form;

use App\Entity\Response;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResponseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file1')
            ->add('file2')
            ->add('content')
            ->add('user')
            ->add('ad')
            ->add('mail')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Response::class,
        ]);
    }
}
