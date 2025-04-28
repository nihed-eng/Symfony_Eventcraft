<?php

namespace App\Form;

use App\Entity\Demande;
<<<<<<< HEAD
use App\Entity\Offre;
=======
<<<<<<< HEAD
=======
use App\Entity\Offre;
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
<<<<<<< HEAD
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
=======
<<<<<<< HEAD
=======
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)

class DemandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
<<<<<<< HEAD
=======
<<<<<<< HEAD
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom',
                'required' => true,
                'attr' => ['placeholder' => 'Entrez le nom de la demande'],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => true,
                'attr' => ['placeholder' => 'Décrivez votre demande...'],
            ]);
    }
=======
>>>>>>> c139a4e (Résolution des conflits)
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
<<<<<<< HEAD
=======
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Demande::class,
        ]);
    }
}
<<<<<<< HEAD
=======
<<<<<<< HEAD

=======
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)
