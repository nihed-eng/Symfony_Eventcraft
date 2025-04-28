<?php

namespace App\Form;

use App\Entity\CommandeDecoration;
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

class CommandeDecorationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantite', IntegerType::class, [
                
            ])
            ->add('dateCommande', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
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
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CommandeDecoration::class,
            'user' => null, // Si tu veux passer l'user plus tard
        ]);
    }
}
