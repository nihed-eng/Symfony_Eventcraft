<?php

namespace App\Form;

use App\Entity\Offre;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class OffreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titreOffre', TextType::class, [
                'label' => "Titre de l'offre",
                'attr' => ['placeholder' => 'Entrez le titre de l\'offre'],
            ])
            ->add('descriptionOffre', TextareaType::class, [
                'label' => "Description",
                'attr' => ['placeholder' => 'Entrez une description'],
            ])
            ->add('typeOffre', TextType::class, [
                'label' => "Type d'offre",
                'attr' => ['placeholder' => 'Ex: Promotion, Réduction...'],
            ])
            ->add('montant', NumberType::class, [
                'label' => "Montant",
                'attr' => ['min' => 0, 'placeholder' => 'Entrez un montant'],
            ])
            ->add('dateExp', DateType::class, [
                'label' => "Date d'expiration",
                'widget' => 'single_text',
<<<<<<< HEAD
            ])
=======
                'required' => true, // s'assurer que le champ est obligatoire
                'attr' => ['placeholder' => 'Choisissez une date'],
            ])
            
>>>>>>> 6ab9b1d (Initial commit)
       ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offre::class,
        ]);
    }
}

