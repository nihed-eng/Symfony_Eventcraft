<?php

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
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class DecorationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
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
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Decoration::class,
        ]);
    }
}
