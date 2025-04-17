<?php

namespace App\Form;

use App\Entity\Forum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
    class ForumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('titre_forum', TextType::class, [
            'label' => 'Titre du forum',
            'required' => true,
            'attr' => ['class' => 'form-control'],
            
            'constraints' => [
                new NotBlank(['message' => 'Le titre du forum est obligatoire.']),
                new Regex([
                    'pattern' => '/^[A-Z]/',
                    'message' => 'Le titre doit commencer par une majuscule.',
                ]),
            ],
        ])

            
        
        ->add('description_forum', TextType::class, [
            'label' => 'Description',
            'required' => true,
            'attr' => ['class' => 'form-control'],
            'constraints' => [
                new NotBlank(['message' => 'La description est obligatoire.']),
                ]                ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Forum::class,
        ]);
    }
}
