<?php

namespace App\Form;

use App\Entity\DesignationPartie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\PouvoirPartie;
use App\Entity\Partie;

// 1. Include Required Namespaces
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityManagerInterface;

class DesignationPartieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('designation')
            //->add('acteurDesigne')
            //->add('acteurDesignant')
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'onPreSetData'));
      //  $builder->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'onPreSubmit'));
    }

    protected function addElements(FormInterface $form, Partie $partie = null) {

        // Add the Neighborhoods field with the properly data
        $form->add('acteurDesigne', EntityType::class, array(
            'required' => true,
            'multiple' => false,
            'placeholder' => 'Selectionnez l\'acteur du pouvoir ...',
            'class' => 'App:ActeurPartie',
            'choices' => $partie->getActeurParties()
        ));

        $form->add('acteurDesignant', EntityType::class, array(
            'required' => false,
            'multiple' => false,
            'expanded' => false,
            'placeholder' => 'Selectionnez l\'acteur du pouvoir ...',
            'class' => 'App:ActeurPartie',
            'choices' => $partie->getActeurParties()
        ));
    }

    function onPreSetData(FormEvent $event) {
        $designationPartie = $event->getData();
        $form = $event->getForm();

        $partie = $designationPartie->getPartie() ? $designationPartie->getPartie() : null;
        $this->addElements($form, $partie);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DesignationPartie::class,
        ]);
    }
}
