<?php
<<<<<<< HEAD
// src/Form/CommandeDecorationType.php
=======
>>>>>>> 6ab9b1d (Initial commit)

namespace App\Form;

use App\Entity\CommandeDecoration;
<<<<<<< HEAD
use App\Entity\Decoration;
use App\Entity\Utilisateur; // Importer la classe Utilisateur
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
=======
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Form\FormError;
>>>>>>> 6ab9b1d (Initial commit)

class CommandeDecorationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
<<<<<<< HEAD
        $user = $options['user']; // Récupérer l'utilisateur passé depuis le contrôleur

        $builder
            ->add('quantite', NumberType::class)
            ->add('prix', NumberType::class, [
                'scale' => 2,  // Définir la précision pour les décimales
=======
        $builder
            ->add('quantite', IntegerType::class, [
                
>>>>>>> 6ab9b1d (Initial commit)
            ])
            ->add('dateCommande', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
<<<<<<< HEAD
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
=======
            ]);

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $commande = $event->getData();
            $form = $event->getForm();

            $decoration = $commande->getDecoration(); // récupérée via le contrôleur
            if (!$decoration) {
                return;
            }

            $quantite = $commande->getQuantite();
            $stockDisponible = $decoration->getStock();

            // Validation : quantité ≤ stock
            if ($quantite > $stockDisponible) {
                $form->get('quantite')->addError(new FormError(
                    'La quantité demandée dépasse le stock disponible (' . $stockDisponible . ').'
                ));
            }

            // Calcul du prix
            $prixTotal = $quantite * $decoration->getprix();
            $commande->setPrix($prixTotal);
        });
>>>>>>> 6ab9b1d (Initial commit)
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CommandeDecoration::class,
<<<<<<< HEAD
            'user' => null, // Ajouter l'option 'user' ici pour qu'elle soit accessible
=======
            'user' => null, // Si tu veux passer l'user plus tard
>>>>>>> 6ab9b1d (Initial commit)
        ]);
    }
}
