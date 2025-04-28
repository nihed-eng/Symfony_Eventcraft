<?php

namespace App\Form;

use App\Entity\Reclamation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
<<<<<<< HEAD
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
=======
<<<<<<< HEAD
=======
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
<<<<<<< HEAD
            ->add('titre', TextType::class, [
=======
<<<<<<< HEAD
            ->add('subject', TextType::class, [
=======
            ->add('titre', TextType::class, [
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Enter the subject of your complaint'
                ],
                'label' => 'Subject'
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'rows' => 5,
                    'placeholder' => 'Describe your complaint in detail'
                ],
                'label' => 'Description'
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
>>>>>>> c139a4e (Résolution des conflits)
            ])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'General' => 'general',
                    'Technical' => 'technical',
                    'Service' => 'service',
                    'Other' => 'other'
                ],
                'attr' => ['class' => 'form-control'],
                'label' => 'Type'
<<<<<<< HEAD
=======
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
<<<<<<< HEAD
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'reclamation_form',
=======
<<<<<<< HEAD
=======
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'reclamation_form',
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)
        ]);
    }
}
