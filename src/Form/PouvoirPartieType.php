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
use Doctrine\ORM\EntityManagerInterface;

class PouvoirPartieType extends AbstractType
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('pouvoir')
            //->add('acteurPossedant')
            //->add('pouvoirDestinataire')
            //->add('conditionPouvoir')
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'onPreSetData'));
      //  $builder->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'onPreSubmit'));
    }

    protected function addElements(FormInterface $form, Partie $partie = null) {

        // Add the Neighborhoods field with the properly data
        $form->add('acteurPossedant', EntityType::class, array(
            'required' => true,
            'multiple' => true,
            'expanded' => true,
            'placeholder' => 'Selectionnez l\'acteur du pouvoir ...',
            'class' => 'App:ActeurPartie',
            'choices' => $partie->getActeurParties()
        ));
    }

    function onPreSetData(FormEvent $event) {
        $pouvoirPartie = $event->getData();
        dump($pouvoirPartie);
        $form = $event->getForm();

        $partie = $pouvoirPartie->getPartie() ? $pouvoirPartie->getPartie() : null;
        $this->addElements($form, $partie);
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
