<?php

namespace App\Form;

use App\Entity\ConditionDesignationPartie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConditionDesignationPartieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('duree')
            ->add('renouvelabilite')
            ->add('isCumulable')
            ->add('conditionDesignation')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ConditionDesignationPartie::class,
        ]);
    }
}
