<?php
// src/Form/CommandeDecorationType.php

namespace App\Form;

use App\Entity\CommandeDecoration;
use App\Entity\Decoration;
use App\Entity\Utilisateur; // Importer la classe Utilisateur
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeDecorationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $options['user']; // Récupérer l'utilisateur passé depuis le contrôleur

        $builder
            ->add('quantite', NumberType::class)
            ->add('prix', NumberType::class, [
                'scale' => 2,  // Définir la précision pour les décimales
            ])
            ->add('dateCommande', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('decoration', EntityType::class, [
                'class' => Decoration::class,
                'choice_label' => 'idDecor',
                'placeholder' => 'Choisir une décoration',
            ])
            ->add('user', EntityType::class, [
                'class' => Utilisateur::class,
                'choices' => [$user],  // Ajouter l'utilisateur connecté comme choix unique
                'choice_label' => 'id', // Afficher l'ID de l'utilisateur, ajuster si nécessaire
                'data' => $user, // Assigner l'utilisateur connecté comme valeur par défaut
                'disabled' => true,  // Désactiver le champ pour que l'utilisateur ne puisse pas changer
            ])
            ->add('save', SubmitType::class, ['label' => 'Enregistrer']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CommandeDecoration::class,
            'user' => null, // Ajouter l'option 'user' ici pour qu'elle soit accessible
        ]);
    }
}
