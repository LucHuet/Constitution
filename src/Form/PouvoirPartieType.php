<?php

namespace App\Form;

use App\Entity\PouvoirPartie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PouvoirPartieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('partie')
            ->add('pouvoir')
            ->add('acteurDestinataire')
            ->add('pouvoirDestinataire')
            ->add('conditionPouvoir')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PouvoirPartie::class,
        ]);
    }
}
