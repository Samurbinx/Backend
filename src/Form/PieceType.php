<?php

namespace App\Form;

use App\Entity\Piece;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class PieceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Title', TextType::class, [
                'label' => 'Título',
                'required' => false,
            ])
            ->add('Materials', CollectionType::class, [
                'label' => false,
                'required' => false,
                'entry_type' => TextType::class, 
                'mapped' => false, // Esto evitará que se genere automáticamente
                'allow_add' => true,               
                'allow_delete' => true,            
                'prototype' => true,               
            ])
            ->add('Height', NumberType::class, [
                'label' => 'Alto (cm)',
                'required' => false
            ])
            ->add('Width', NumberType::class, [
                'label' => 'Ancho (cm)',
                'required' => false
            ])
            ->add('Depth', NumberType::class, [
                'label' => 'Profundo (cm)',
                'required' => false
            ])
            ->add('Images', FileType::class, [
                'label' => 'Añadir archivo (JPEG, JPG, PNG, WEBP, MP4, MOV, AVI)',
                'multiple' => true,
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new All([
                        new File([
                            'maxSize' => '500M',
                            'mimeTypes' => [
                                'image/jpeg',
                                'image/jpg',
                                'image/png',
                                'image/webp',
                                'video/mp4',
                                'video/quicktime',
                                'video/x-msvideo',
                            ],
                            'mimeTypesMessage' => 'Formato no válido',
                        ])
                    ]),
                ],
                'attr' => ['class' => 'form-control']
            ])
           
            

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Piece::class,
       ]);
    }
}
