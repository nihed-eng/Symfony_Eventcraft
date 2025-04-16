<?php

namespace App\Form;

use App\Entity\Reclamation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
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
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'reclamation_form',
        ]);
    }
}
