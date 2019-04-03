<?php

namespace App\Form;

use App\Entity\ActeurPartie;
use App\Repository\ActeurRepository;
use App\Form\DesignationPartieType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Form\ActeurPartieType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\DataTransformer\PouvoirPartieDataTransformer;

class ActeurPartieCompletType extends AbstractType
{
    private $transformer;

    public function __construct(PouvoirPartieDataTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('acteurPartie', ActeurPartieType::class)
            ->add('designation', DesignationPartieType::class)
            ->add('pouvoirs', CollectionType::class, array(
            'entry_type' => TextType::class,
            'allow_add' => true,
            ))
            ->add('pouvoirsControles', CollectionType::class, array(
            'entry_type' => TextType::class,
            'allow_add' => true,
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        /*$resolver->setDefaults([
            'data_class' => ActeurPartie::class,
        ]);*/
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
