<?php
namespace App\Form;

use App\Entity\Reservation;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
     $builder
    ->add('dateDebut', DateType::class, [
        'label' => 'Date Début',
        'widget' => 'single_text',  // Utilisation de 'single_text' pour un champ unique
        'attr' => [
            'class' => 'form-control datepicker', // Ajoutez cette classe pour cibler le champ avec le plugin JS
            'id' => 'date-start', // L'id du champ
            'autocomplete' => 'off'
        ],
        'required' => true
    ])
    ->add('dateFin', DateType::class, [
        'label' => 'Date Fin',
        'widget' => 'single_text',  // Utilisation de 'single_text' pour un champ unique
        'attr' => [
            'class' => 'form-control datepicker', // Ajoutez cette classe pour cibler le champ avec le plugin JS
            'id' => 'date-end', // L'id du champ
            'autocomplete' => 'off'
        ],
        'required' => true
    ]);
            
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
            'salle' => null
        ]);
    }
}