<?php
<<<<<<< HEAD

=======
>>>>>>> 6ab9b1d (Initial commit)
namespace App\Form;

use App\Entity\Decoration;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
<<<<<<< HEAD
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

=======
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\PositiveOrZero;
>>>>>>> 6ab9b1d (Initial commit)

class DecorationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
<<<<<<< HEAD
            ->add('nomDecor', TextType::class)
            ->add('typeDecor', TextType::class)
            ->add('descriptionDecor', TextType::class)
            ->add('stock', NumberType::class)
            ->add('prix', NumberType::class)
            ->add('imagedeco', FileType::class, [
                'label' => 'Image de la décoration (JPG, PNG, etc)',
                'mapped' => false, // car ce champ n'est pas directement mappé à une propriété de l'entité (sinon besoin de setter)
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/webp',
                        ],
                        'mimeTypesMessage' => 'Veuillez uploader une image valide (JPEG, PNG, WEBP)',
                    ])
                ],
            ])
// SUPPRIME ceci :
->add('user', null, ['choice_label' => 'id'])
            ->add('save', SubmitType::class, ['label' => 'Save Decoration']);
=======
            ->add('nomDecor', TextType::class, [
                'label' => 'Nom de la décoration',
               'empty_data' => '',
                'attr' => [
                    'placeholder' => 'Entrez le nom de la décoration'
                ]
            ])
            ->add('typeDecor', TextType::class, [
                'label' => 'Type de décoration',
                'empty_data' => '',
                'attr' => [
                    'placeholder' => 'Entrez le type de décoration'
                ]
            ])
            ->add('descriptionDecor', TextareaType::class, [
                'label' => 'Description',
                'empty_data' => '',
                'attr' => [
                    'rows' => 3,
                    'placeholder' => 'Décrivez la décoration en détail'
                ]
            ])
            ->add('stock', IntegerType::class, [
                'label' => 'Quantité en stock',
                'empty_data' => 0,
    'constraints' => [
        new NotBlank(['message' => 'Le stock ne peut pas être vide']),
        new PositiveOrZero(['message' => 'Le stock doit être un nombre positif ou nul'])
    ],
                'attr' => [
                    'min' => 0,
                    'placeholder' => 'Quantité disponible'
                ]
            ])
            ->add('prix', NumberType::class, [
                'label' => 'Prix',
                'empty_data' => 0.0, 
                'constraints' => [
                    new NotBlank(['message' => 'Le prix ne peut pas être vide']),
                    new Positive(['message' => 'Le prix doit être un nombre positif'])
                ],
                'attr' => [
                    'step' => '0.01',
                    'min' => '0.01',
                    'placeholder' => 'Prix en dinars'
                ]
            ])
            ->add('imagedeco', FileType::class, [
                'label' => 'Image de la décoration',
                'mapped' => false,
                'required' => false,
              'empty_data' => '',
                'attr' => [
                    'accept' => 'image/jpeg,image/png,image/webp'
                ]
            ]);
>>>>>>> 6ab9b1d (Initial commit)
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Decoration::class,
        ]);
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> 6ab9b1d (Initial commit)
