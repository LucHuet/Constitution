<?php

namespace App\Form;

use App\Entity\ActeurPartie;
use App\Repository\ActeurRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActeurPartieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('nombreIndividus')
            ->add('typeActeur', EntityType::class, array(
                'required' => true,
                'multiple' => false,
                'expanded' => false,
                'class'  => 'App:Acteur',
                'query_builder' => function(ActeurRepository $acteurRepository) {
                  return $acteurRepository->createQueryBuilder('q')->where('q.id != :identifier')
                     ->setParameter('identifier', 2);
                 },
             ));
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ActeurPartie::class,
        ]);
    }
}
