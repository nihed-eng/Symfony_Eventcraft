<?php

namespace App\Form;

use App\Entity\Salle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class SalleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomSalle', TextType::class, [
                'label' => 'Nom de la salle',
                'attr' => [
                    'required' => true,
                    'minlength' => 3,
                    'maxlength' => 50,
                    'pattern' => '[A-Za-z0-9\s\-]+',
                    'title' => 'Le nom doit contenir au moins 3 caractères, sans caractères spéciaux.'
                ]
            ])
            ->add('capacite', IntegerType::class, [
                'label' => 'Capacité',
                'attr' => [
                    'min' => 1,
                    'max' => 1000,
                    'title' => 'Capacité minimale : 1'
                ]
            ])
            ->add('equipement', TextareaType::class, [
                'label' => 'Équipements',
                'attr' => ['rows' => 3]
            ])
            ->add('imageFile', FileType::class, [
                'label' => 'Image',
                'mapped' => false,
                'required' => false,
<<<<<<< Updated upstream
                'constraints' => [
                    new File([
                        'maxSize' => '2M',
                        'mimeTypes' => ['image/jpeg', 'image/png'],
                    ])
                ]
=======
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => ['image/jpeg', 'image/png'],
                    ])
                ],
>>>>>>> Stashed changes
            ])
            ->add('locationSalle', TextType::class, [
                'label' => 'Localisation'
            ])
            ->add('qualite', TextType::class, [
                'label' => 'Qualité'
            ])
            ->add('prix', NumberType::class, [
                'label' => 'Prix (€)',
                'attr' => [
                    'min' => 0,
                    'step' => 0.01,
                    'title' => 'Le prix doit être supérieur ou égal à 0'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Salle::class,
        ]);
    }
}
