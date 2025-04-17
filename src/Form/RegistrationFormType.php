<?php

namespace App\Form;

use App\DTO\RegistrationModel;
use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prenom', TextType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'First Name'],
            ])
            ->add('nom', TextType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Last Name'],
            ])
            ->add('email', EmailType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Email'],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => true,
                'attr' => ['class' => 'form-check-input'],
                'property_path' => 'dto.agreeTerms',
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => true,
                'property_path' => 'dto.plainPassword',
                'first_options' => [
                    'attr' => ['class' => 'form-control', 'placeholder' => 'Password'],
                ],
                'second_options' => [
                    'attr' => ['class' => 'form-control', 'placeholder' => 'Confirm Password'],
                ],
                'invalid_message' => 'The password fields must match.',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RegistrationModel::class,
            'validation_groups' => ['Default'],
        ]);
    }
}
