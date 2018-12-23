<?php

namespace App\Form;

use App\Entity\DesignationPartie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\PouvoirPartie;
use App\Entity\Partie;
use App\Form\DataTransformer\ActeurPartieDataTransformer;
// 1. Include Required Namespaces
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityManagerInterface;

class DesignationPartieType extends AbstractType
{
    private $transformer;

    public function __construct(ActeurPartieDataTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('designation')
            //->add('acteurDesigne')
            //->add('acteurDesignant')
            /*->add('acteurDesigne', TextType::class, array(
                // validation message if the data transformer fails
                'invalid_message' => 'Ce numéro d\'acteur n\'est pas valide',
            ))*/
            ->add('acteurDesignant', TextType::class, array(
                // validation message if the data transformer fails
                'invalid_message' => 'Ce numéro d\'acteur n\'est pas valide',
            ))
        ;
        /*$builder->get('acteurDesigne')
            ->addModelTransformer($this->transformer);*/
        $builder->get('acteurDesignant')
            ->addModelTransformer($this->transformer);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DesignationPartie::class,
        ]);
    }

    public function getBlockPrefix()
    {
      return '';
    }
}
