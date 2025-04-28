<?php

namespace App\Form;

<<<<<<< HEAD

=======
<<<<<<< HEAD
=======

>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)
use App\Entity\Salle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
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
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\File;

class SalleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomSalle', TextType::class, [
                'label' => 'Nom de la salle',
                'attr' => ['class' => 'form-control'],
               
            ])
            ->add('capacite', IntegerType::class, [
                'label' => 'Capacité',
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new Positive(['message' => 'La capacité doit être un nombre positif']),
                ],
            ])
           
            ->add('equipement', TextareaType::class, [
                'label' => 'Équipements',
                'attr' => ['class' => 'form-control', 'rows' => 3],
               
            ])
            ->add('imageFile', FileType::class, [
                'label' => 'Image',
                'mapped' => false,
                'required' => false,
                'attr' => ['class' => 'form-control'],
<<<<<<< HEAD
=======
<<<<<<< HEAD
              
=======
>>>>>>> c139a4e (Résolution des conflits)
                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => ['image/jpeg', 'image/png'],
                    ])
                ],
<<<<<<< HEAD
=======
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)
            ])
            ->add('locationSalle', TextType::class, [
                'label' => 'Localisation',
                'attr' => ['class' => 'form-control'],
             
            ])
<<<<<<< HEAD
            ->add('qualite', ChoiceType::class, [
=======
<<<<<<< HEAD
            ->add('qualite', TextType::class, [
>>>>>>> c139a4e (Résolution des conflits)
                'label' => 'Qualité',
                'choices' => [
                    'Bien' => 'Bien', 
                    'Très bien' => 'Très bien',
                    'Superbe' => 'Superbe',
                    'Exceptionnelle' => 'Exceptionnelle'
                ],
                'attr' => ['class' => 'form-control'],
<<<<<<< HEAD
                'required' => false,
                'placeholder' => 'Sélectionnez une qualité...'
=======
                'required' => false
=======
            ->add('qualite', ChoiceType::class, [
                'label' => 'Qualité',
                'choices' => [
                    'Bien' => 'Bien', 
                    'Très bien' => 'Très bien',
                    'Superbe' => 'Superbe',
                    'Exceptionnelle' => 'Exceptionnelle'
                ],
                'attr' => ['class' => 'form-control'],
                'required' => false,
                'placeholder' => 'Sélectionnez une qualité...'
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)
            ])
            ->add('prix', NumberType::class, [
                'label' => 'Prix (€)',
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new Positive(['message' => 'Le prix doit être un nombre positif']),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Salle::class,
        ]);
    }
<<<<<<< HEAD
}
=======
<<<<<<< HEAD
}
=======
}
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)
