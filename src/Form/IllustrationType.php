<?php

namespace App\Form;

use App\Entity\Illustration;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
class IllustrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Title', TextType::class, [
                'label' => 'Título',
                'required' => true, // No permite valores nulos
            ])
            ->add('Collection', TextareaType::class, [
                'label' => 'Colección',
                'required' => false, // Permite valores nulos
            ])
            ->add('Price', TextType::class, [
                'label' => 'Precio',
                'required' => true, // No permite valores nulos
            ])
            ->add('Stock', TextareaType::class, [
                'label' => 'Stock',
                'required' => false, // Permite valores nulos
            ])
            ->add('Image', FileType::class, [
                'label' => 'Añadir archivo (JPEG, JPG, PNG, WEBP)',
                'multiple' => false,
                'mapped' => false,
                'required' => false,
                'constraints' => [
                        new File([
                            'maxSize' => '500M',
                            'mimeTypes' => [
                                'image/jpeg',
                                'image/jpg',
                                'image/png',
                                'image/webp',
                            ],
                            'mimeTypesMessage' => 'Formato no válido',
                        ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Illustration::class,
        ]);
    }
}
