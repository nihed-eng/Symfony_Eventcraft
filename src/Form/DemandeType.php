<?php

namespace App\Form;

use App\Entity\Demande;
use App\Entity\Offre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class DemandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
{
    $builder
        ->add('nom', TextType::class, [
            'label' => 'Nom',
            'attr' => ['placeholder' => 'Entrez le nom de la demande'],
            'constraints' => [
                new NotBlank([
                    'message' => 'Le nom ne peut pas être vide.'
                ]),
                new Length([
                    'min' => 3,
                    'minMessage' => 'Le nom doit comporter au moins {{ limit }} caractères.',
                    'max' => 255,
                    'maxMessage' => 'Le nom ne peut pas dépasser {{ limit }} caractères.'
                ])
            ]
        ])
        ->add('description', TextareaType::class, [
            'label' => 'Description',
            'attr' => ['placeholder' => 'Décrivez votre demande...'],
            'constraints' => [
                new NotBlank([
                    'message' => 'La description ne peut pas être vide.'
                ]),
                new Length([
                    'min' => 10,
                    'minMessage' => 'La description doit comporter au moins {{ limit }} caractères.'
                ])
            ]
        ])
        ->add('offre', EntityType::class, [
            'class' => Offre::class,
            'choice_label' => 'titreOffre',
            'label' => 'Offre',
            'placeholder' => 'Choisir une offre',
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez choisir une offre.'
                ])
            ]
        ]);
}

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Demande::class,
        ]);
    }
}
