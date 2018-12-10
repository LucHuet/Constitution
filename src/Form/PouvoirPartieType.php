<?php

namespace App\Form;

use App\Entity\PouvoirPartie;
use App\Entity\Partie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\Common\Collections\ArrayCollection;

// 1. Include Required Namespaces
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Form\DataTransformer\ActeurPartieDataArrayTransformer;

class PouvoirPartieType extends AbstractType
{
    private $transformer;

    public function __construct(ActeurPartieDataArrayTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('pouvoir')
            ->add('acteurPossedant', TextType::class, array(
                // validation message if the data transformer fails
                'invalid_message' => 'Ce numéro d\'acteur n\'est pas valide',
            ))
        ;
        $builder->get('acteurPossedant')
            ->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PouvoirPartie::class,
        ]);
    }

    public function getBlockPrefix()
    {
      return '';
    }
}
