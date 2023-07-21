<?php

namespace App\Form;

use App\Entity\Formation;
use App\Entity\Session;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SessionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('sessionName', TextType::class, [
                'label'=>'Nom de la session',
            ])
            ->add('nbPlace', TextType::class, [
                'label'=>'Nombre de places',
            ])
            ->add('startSession', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('endSession', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('sessionFormation')
            ->add('formateur')
            ->add('submit', SubmitType::class, [
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Session::class,
        ]);
    }
}

// checkez collectionType
// pour les modules on fait ça directement dans la vue showSession
