<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('sex', TextType::class, [
                'label'=>'Sexe'
            ])
            ->add('email', TextType::class, [
                'label'=>'Entrez votre email'
            ])
            ->add('phoneNumber', TextType::class, [
                'label'=>'Entrez votre numéro de téléphone'
            ])
            ->add('city', TextType::class, [
                'label'=>'Entrez votre ville'
            ])
            ->add('birthday', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('firstName', TextType::class, [
                'label'=>'Entrez votre prénom'
            ])
            ->add('lastName', TextType::class, [
                'label'=>'Entrez votre nom'
            ])
            ->add('submit', SubmitType::class, [
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}